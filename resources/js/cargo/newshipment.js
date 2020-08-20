require('../bootstrap')
import Item from "./Item";
import Shipment from "./Shipment";
import Server from "../Server";
var app = new Vue({
    el: "#appId",
    data: {
        Shipment: new Shipment(),
        ItemForm: new Item(),
        Looading: false,
        LoadingText: "loading...",
        errorMessage: null,
        successMessage: null,
        Server: new Server()
    },
    mounted() {},
    methods: {
        addNewItem() {

            if (this.ItemForm.isFilled()) {
                this.Shipment.addNewItem(this.ItemForm);
                this.ItemForm = new Item();
            } else {
                alert(this.ItemForm.errorMessage);
            }

        },
        removeItem(item) {
            console.log('will remove ', item);
            this.Shipment.removeItem(item);
        },

        SaveShipment() {
            var form = this.Shipment.getFormData();
            this.Serve('addShipment', form, this.saveItems);
            // this.Server.setRequest(form);
            // this.Server.serverRequest('/api/addShipment', this.saveItems, this.showError);
        },
        getFormCred() {
            var form = new FormData();
            form.append('company_token', window.company_token);
            form.append('company_id', window.company_id);
            return form;
        },
        saveItems(newShipment) {
            var len = this.Shipment.items.length;
            console.log('----saving items---- ', this.Shipment.items.length);
            for (var i = 0; i < len; i++) {
                console.log('item track id ', newShipment);
                var form = this.Shipment.items[i].getFormData(newShipment.data.id);
                this.Serve('addItem', form, this.itemAdded)
            }
        },
        itemAdded(data) {
            this.Shipment.savedItems += 1;
            if (this.Shipment.savedItems == this.Shipment.items.length) {
                this.successMessage = 'Successfully added all items';
                this.Shipment = new Shipment();
                this.hideSwal();
                this.showSuccess();
            }
        },

        Serve(url, data, callback) {
            console.log('servering ', url);
            console.log(data);
            var _this = this;
            var config = {
                onUploadProgress: function(progressEvent) {
                    var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    _this.LoadingText = "loading..." + percentCompleted + "%";
                }
            }
            this.showLoader();
            axios.defaults.baseURL = '/api/';
            axios.post(url, data)
                .then(function(res) {
                    if (res.data['isSuccess'] == true) {
                        if (callback != null)
                            callback(res.data);
                    } else if (res.data['errorMessage'] != undefined) {
                        _this.errorMessage = res.data["errorMessage"];
                        _this.showError();
                    } else {
                        _this.errorMessage = "Server error - Unknown response";
                        _this.showError();
                    }
                })
                .catch(function(err) {
                    _this.errorMessage = err.message;
                    _this.showError();
                });
        },

        showLoader() {
            var t;
            Swal.fire({
                title: "Processing... please wait",
                html: this.LoadingText,
                onBeforeOpen: function() {
                    Swal.showLoading()
                },
                onClose: function() {
                    clearInterval(t)
                },
                allowOutsideClick: !1
            }).then(function(t) {
                t.dismiss === Swal.DismissReason.timer && console.log("I was closed by the timer")
            })
        },
        hideSwal() {
            $('.swal2-container').remove()
            $('body').removeClass('swal2-shown swal2-height-auto');
        },

        showError(error) {
            Swal.fire({
                title: "Something is wrong",
                text: error == null ? this.errorMessage : error,
                type: "error",
                cancelButtonColor: "#f46a6a",
            }).then(function(t) {})
        },


        showSuccess() {

            Swal.fire({
                title: "Success",
                text: this.successMessage,
                type: "success",
                confirmButtonColor: "#3b5de7",
            });
        },


    },
});