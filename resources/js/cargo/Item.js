import {
    times
} from "lodash";

export default class Item {

    constructor() {
        this.item_name = null;
        this.item_quantity = 0;
        this.item_cpm = 0;
        this.item_supplier = null;
        this.item_unit = 1;
        this.item_remarks = null;
        this.errorMessage = null;
        this.item_kgs = null;
        this.item_total = 1; //unit wise total
        this.item_item_total = 0; //items in each unit
    }

    isFilled() {
        if (this.item_name == null || this.item_name.length <= 0) {
            this.errorMessage = 'The item name is required';
            return false;
        } else if (this.item_quantity == null || this.item_quantity <= 0) {
            this.errorMessage = 'The item quantity is required';
            return false;
        } else if (this.item_cpm == null || this.item_cpm < 0) {
            this.errorMessage = 'The item cpm is required';
            return false;
        } else if (this.item_supplier == null || this.item_supplier.length <= 0) {
            this.errorMessage = 'The item supplier is required';
            return false;
        } else if (this.item_remarks == null || this.item_remarks.length <= 0) {
            this.errorMessage = 'The item remarks is required';
            return false;
        }
        return true;
    }

    getFormData(trackId) {
        return {
            'company_token': window.company_token,
            'company_id': window.company_id,
            'host_type': window.host_type,
            'item_track_id': trackId,
            'item_name': this.item_name,
            'item_quantity': this.item_quantity,
            'item_cpm': this.item_cpm,
            'item_supplier': this.item_supplier,
            'item_unit': this.item_unit + '/' + this.item_total,
            'item_remarks': this.item_remarks,
            'item_kgs': this.item_item_total,
            'item_total': this.item_item_total
        };
    }
}