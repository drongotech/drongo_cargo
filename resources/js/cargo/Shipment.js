export default class Shipment {

    constructor() {
        this.customer_name = null;
        this.customer_telephone = null;
        this.origin_city = null;
        this.origin_country = null;
        this.destination_country = null;
        this.destination_city = null;

        this.errorMessage = null;
        this.items = [];
        this.savedItems = 0;
    }
    addNewItem(newItem) {
        this.items.forEach(item => {
            if (item.item_name == newItem.item_name) {
                newItem.item_unit += 1;
                newItem.item_total += 1;
                this.updateItemTotal(newItem);
            }
        });
        this.items.push(newItem);
    }

    updateItemTotal(newItem) {
        var len = this.items.length;
        for (var i = 0; i < len; i++) {
            if (this.items[i].item_name == newItem.item_name) {
                this.items[i].item_total = newItem.item_total;
            }
        }
    }
    removeItem(item) {
        var newItems = [];

        var len = this.items.length;
        var indexItem = this.items.indexOf(item);
        item.item_total -= 1;
        for (var i = 0; i < len; i++) {
            if (this.items[i].item_name == item.item_name && i == indexItem) {
                continue;
            } else {
                if (this.items[i].item_name == item.item_name) {
                    if (this.items[i].item_unit > 1)
                        this.items[i].item_unit -= 1;
                    this.updateItemTotal(item);
                }
                newItems.push(this.items[i]);
            }


        }
        this.items = newItems;
    }
    getFormData() {
        var form = {
            'company_token': window.company_token,
            'company_id': window.company_id,
            'host_type': window.host_type,
            'customer_name': this.customer_name,
            'customer_phone': this.customer_telephone,
            'city_of_origin': this.origin_city,
            'country_of_origin': this.origin_country,
            'destination_city': this.destination_city,
            'destination_country': this.destination_country,
        };
        return form;
    }

}