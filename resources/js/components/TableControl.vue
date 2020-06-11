<!-- meine notizen
// durchschauen
    // https://vuejsdevelopers.com/2018/02/05/vue-laravel-crud/
    // neue table
    //https://vuejsexamples.com/a-lightweight-vue-datatable-component-with-no-dependencies/
    axios not working
            // axios.get("http://localhost:8080/public/index.php/list/actor")
        //     .then(response => {this.results = response.data.results})



-->



<template>
    <div id="datatable-control">
        <h3 class="title">{{ tableTitle }}</h3>

        <!-- Form Modal with edit funtion -->
        <dialog-modal
            :dialog-id="'edit-form-dialog'"
            :dialog-title="'Edit Record'"
            :form-definition="editFormDefinition"
            v-bind:form-data=formData
            v-bind:dialog-options="dropdownListing"
            :dialogCallback="dialogCallback">
        </dialog-modal>

        <!-- Datatable -->
        <div>
            <div class="userInfo" id="userInfo">
            </div>
            <div class="search-container" v-if="isSearchAble">
                <!--
                <form action="search/actor" method="post">
                -->
                <form>
                    <input id="input-search" type="text" placeholder="Search.." name="q">
                    <button id="btn-search" type="submit">
                    <svg aria-hidden="true" class="s-input-icon s-input-icon__search svg-icon iconSearch" width="18" height="18" viewBox="0 0 18 18"><path d="M18 16.5l-5.14-5.18h-.35a7 7 0 10-1.19 1.19v.35L16.5 18l1.5-1.5zM12 7A5 5 0 112 7a5 5 0 0110 0z"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        <!--            @on-update="dtUpdateSort"-->
        <!--            :is-loading="isLoading"-->
        <!--            :css="datatableCss"-->
        <!--            v-bind:identifier-of-entry="identifierOfEntry"-->
        <!--            :sort-field="sortField"-->
        <!--            :sort="sort"-->
        <!--            :data="data || []"-->
        <datatable-light
            :header-fields="headerFields"
            :sort-field="'slug'"
            :sort="'asc'"
            v-bind:initial-data="workingData"
            not-found-msg="Items not found"
            :track-by="trackBy"
            v-bind:entry-url="entryUrl"
            :dtButtonControl="dtButtonControl"
        >
        </datatable-light>
       <br>
   </div>
</template>


<script>
    // This imports <b-modal> as well as the v-b-modal directive as a plugin:
    import { ButtonPlugin }  from "bootstrap-vue";
    Vue.use(ButtonPlugin);

    import Vue from 'vue';

    const addZero = value => ("0" + value).slice(-2);

    const formatDate = value => {
        if (value) {
            const dt = new Date(value);
            return `${addZero(dt.getDate())}/${addZero(
                dt.getMonth() + 1
            )}/${dt.getFullYear()}`;
        }
        return "";
    };

    export default {
        name: "TableControl",
        props : {
            tableTitle: {
                type: String,
                required: false,
                default: "MyTable"
            },
            headerFields: {
                type: Array,
                required: true
            },
            initialData: {
                type: Array,
                required: true
            },
            isSearchAble: {
                type: Boolean,
                required: false,
                default: false
            },
            // unique column
            trackBy: {
                type: String,
                required: false,
                default: "none"
            },
            editFormDefinition: {
                type: Array,
                required: true,
                default: function () {
                    // layout of a form definition that must be provided
                    return [
                        {
                            fieldName: "slug",
                            fieldLabel: "Slug",
                            fieldIsDisplayed: false,
                            isMandatory: true,
                            validationFailedMessage: "A Slug is required",
                            fieldType: "b-form-input",
                            // data field must be specified otherwise v-bind does not work
                            fieldData: ""
                        },
                        {
                            fieldName: "name",
                            fieldLabel: "Name",
                            fieldIsDisplayed: true,
                            isMandatory: true,
                            validationFailedMessage: "A super Name is required",
                            fieldType: "b-form-input",
                            // data field must be specified otherwise v-bind does not work
                            fieldData: ""
                        },
                        {
                            fieldName: "description",
                            fieldLabel: "Description",
                            fieldIsDisplayed: true,
                            isMandatory: true,
                            validationFailedMessage: "A Description is required",
                            fieldType: "b-form-input",
                            fieldData: ""
                        },
                        {
                            fieldName: "film_id",
                            fieldLabel: "FilmId",
                            fieldIsDisplayed: true,
                            isMandatory: true,
                            validationFailedMessage: "A FilmId is required",
                            fieldType: "b-form-select",
                            fieldData: ""
                        }
                    ];
                }
            },
            //when edit has finished what should happen? dialogOkCallback
            // [ update, reload ] is supported
            editSuccessAction: {
                type: String,
                required: true,
                default: "update"
            },
            // where to get the available options for the select
            optionsUrl: {
                type: String,
                required: false,
                default: "list/film"
            },
            // url that fetches the complete dataset
            getTableDataUrl:{
                type: String,
                required: true,
                default: "list/actor"
            },
            // url to use to update / delete a table entry
            entryUrl:{
                type: String,
                required: true,
                default: "actor/"
            },
            // table row contains multiple attributes which of them should be used to update an entry e.g. /actor/{slug}
            identifierOfEntry:{
                type: String,
                required: true,
                default: "slug"
            },
            // url where to post queries
            searchTableDataUrl:{
                type:String,
                required: false,
                default: "search/actor"
            },
            // is appended to the body when posting to searchUrl
            searchSelector:{
                type: String,
                required: false,
                default: "q="
            }
        },
        data: function() {
            return {
                workingData: this.initialData,
                formData: {},
                dropdownListing: []
            };
        },
        methods: {
            actionSearch: function (event){
                if ( this.isSearchAble === true ){
                    var searchString = document.getElementById('input-search').value;
                    if (typeof searchString !== 'undefined' && searchString === ""){
                        if ( event.type === "keyup" && searchString === "" ){
                            this.updateUserInfo("info","Removing search filter.");
                            this.serverDataGet( this.getTableDataUrl );
                        } if ( event.type === "click" ){
                            this.updateUserInfo("warning","The search string must not be empty! Reseting Filter.");
                            this.serverDataGet( this.getTableDataUrl );
                        }
                    } else {
                        this.updateUserInfo("info","Updating...");
                        this.serverDataSearch(this.searchTableDataUrl,this.searchSelector + searchString);
                    }
                } else {
                    this.updateUserInfo("warning","Searching is not supported.");
                }

            },
            dtButtonControl: function(event, props){
                if (event.target.id === 'edit-btn-seperate'){
                    window.location.href = this.entryUrl + props.rowData[ this.identifierOfEntry ] + '/edit';
                } else if (event.target.id === 'edit-btn'){
                    this.dtEditClick(props);
                } else if (event.target.id === 'remove-btn'){
                    this.dtRemoveClick(props);
                } else if (event.target.id === 'details-btn'){
                    // href would be better but it introduces more coupling with the table
                    window.location.href = this.entryUrl + props.rowData[ this.identifierOfEntry ];
                }
            },
            dtEditClick: function(props){
                this.formData = {};
                this.formData = props.rowData;
                this.$bvModal.show( "edit-form-dialog" );
            },
            dtRemoveClick: function(props){
                axios.delete(this.entryUrl + props['rowData'][this.identifierOfEntry] )
                    .then(response => {
                        const deletedItem = this.workingData.find( (entry) => {
                            // find the deleted element
                            return entry.slug === props['rowData'][this.identifierOfEntry];
                        } )
                        if (~deletedItem) {// if the item exists in array
                            this.workingData.splice(this.workingData.indexOf(deletedItem), 1 ) //delete the row
                            // this.updateTableView(); // update the view
                        }
                    }).catch(  (error) => {
                        this.dialogFailedCallback();
                });
            },
            dialogCallback( formulaData ) {
                // console.log("running " + JSON.stringify(formulaData) );
                axios.put(this.entryUrl + formulaData[this.identifierOfEntry] , formulaData )
                    .then( (response) => {
                        this.dialogOkCallback()
                    }).catch(  (error) => {
                        this.dialogFailedCallback();
                });
            },
            dialogOkCallback() {

                if (this.editSuccessAction === 'reload'){
                    this.updateUserInfo("info", "record has been updated. reloading page");
                    window.location.href = '';
                } else if ( this.editSuccessAction === 'update'){
                    this.updateUserInfo("info", "record has been updated.");
                    this.serverDataGet( this.getTableDataUrl );
                }
            },
            dialogFailedCallback() {
                this.updateUserInfo("warning", "cannot update record");
            },
            processBackendResponse: function (response){
                //document.getElementById("container1").insertAdjacentHTML('beforeend', '<div>'+ JSON.stringify(response) + '</div>');
                var newData = [];
                for (var key in response){
                    // dynamically change date when isDate is present
                    for (var hIndex in this.headerFields){
                        if (typeof this.headerFields[hIndex].isDate !== 'undefined' && this.headerFields[hIndex].isDate == true){
                            var headerName = this.headerFields[hIndex]["name"];
                            response[key][headerName] = formatDate(response[key][headerName] );
                        }
                    }
                    newData.push( response[key] );
                }
                // needed to rerender the page
                this.workingData = newData;
                // this.updateTableView();
            },
            serverDataGet: function (Url){
                axios.get(Url).then( (res) => {
                    this.processBackendResponse(res.data);
                    this.updateUserInfo("info", "Updating...");
                }).catch(  (error) => {
                    this.updateUserInfo("warning", "Update failed");
                });
            },
            serverDataSearch: function (Url, body){
                axios.post(Url, body).then( (res) => {
                    this.processBackendResponse(res.data);
                    this.updateUserInfo("info", "Updating...");
                }).catch(  (error) => {
                    this.updateUserInfo("warning", "Update failed");
                });
            },
            updateUserInfo: function (level, info){
                var element = document.getElementById("userInfo");
                element.innerHTML = info;
                if (level === "success" ){
                    element.classList.add("alert");
                    element.classList.add("alert-success");
                } else if (level === "info" ){
                    element.classList.add("alert");
                    element.classList.add("alert-info");
                } else if ( level === "warning" ){
                    element.classList.add("alert");
                    element.classList.add("alert-warning");
                } else {
                    element.classList.add("alert");
                    element.classList.add("alert-danger");
                }
                element.classList.add("hidden");
                setTimeout(function(){
                    // element.classList.remove("hidden");
                    element.className = 'userInfo';
                    element.innerHTML = '';
                }, 10000);
            }
        },
        created() {
            // reformat initial data
            this.processBackendResponse(this.workingData);
            // get list for dropdowns
            axios.get( this.optionsUrl ).then( (res) => {
                // console.log(res)
                this.dropdownListing = res.data
            }).catch(  (error) => {
                this.updateUserInfo("warn", "Failed to get optionsdata");
            });
        },
        mounted() {
            if (this.isSearchAble){
                document.getElementById('input-search').addEventListener("keyup", this.actionSearch);
                document.getElementById('btn-search').addEventListener("click", this.actionSearch);
            }
        }
    };
</script>


<style>

    #datatable-control .userInfo {
        float: left;
        padding: 6px;
        font-size: 17px;
    }

    #datatable-control .hidden{
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s 10s, opacity 10s linear;
    }

    #datatable-control .search-container {
        float: right;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-position: 10px 10px;
        background-repeat: no-repeat;
        background-color: white;
    }

    #datatable-control .search-container input[type=text] {
        padding: 6px;
        font-size: 17px;
        border: none;
    }

    #datatable-control .search-container button {
        float: right;
        padding: 6px 10px;
        background: #ddd;
        font-size: 17px;
        border: none;
        cursor: pointer;
    }

    #datatable-control .search-container button:hover {
        background: #ccc;
    }

    @media screen and (max-width: 600px) {
        #datatable-control .search-container .search-container {
            float: none;
        }
        #datatable-control a, #datatable-control .search-container input[type=text], #datatable-control .search-container button {
            float: none;
            display: block;
            text-align: left;
            width: 100%;
            margin: 0;
            padding: 14px;
        }
        #datatable-control .search-container input[type=text] {
            border: 1px solid #ccc;
        }
    }
</style>
