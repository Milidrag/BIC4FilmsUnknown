class Errors {
    constructor() {
        this.errors = {};
    }

    has(field){
        // bugfix sometimes this.erros is undefined
        if ( typeof this.errors !== 'undefined' ){
            return this.errors.hasOwnProperty(field);
        } else {
            return null;
        }

    }

    any(){
        return Object.keys(this.errors).length > 0;
    }

    get(field) {
        if(this.errors[field]){
            return this.errors[field][0];
        }
    }

    record(errors){
        this.errors = errors;
    }

    clear(field){
        if (field) delete this.errors[field];
        else this.errors = {};
    }
}

export default Errors;
