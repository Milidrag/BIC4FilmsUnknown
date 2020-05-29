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
    <div id="datatable-light">
        <h3 class="title">{{ tableTitle }}</h3>

        <div>
            <b-button id="show-btn" @click="$bvModal.show('bv-modal-example')">Open Modal</b-button>

            <b-modal id="bv-modal-example" hide-footer>
                <template v-slot:modal-title>
                    Using <code>$bvModal</code> Methods
                </template>
                <div class="d-block text-center">
                    <h3>Hello From This Modal!</h3>
                </div>
                <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-example')">Close Me</b-button>
            </b-modal>
        </div>


        <dialog-modal></dialog-modal>

        <!-- Datatable -->
        <div>
            <div class="userInfo" id="userInfo">
            </div>
            <div class="search-container">
                <!--
                <form action="search/actor" method="post">

                -->
                <form>
                </form>
                    <input type="hidden" name="_token" :value="csrf">
                    <input id="input-search" type="text" placeholder="Search.." name="q">
                    <button id="btn-search" type="submit">
                    <svg aria-hidden="true" class="s-input-icon s-input-icon__search svg-icon iconSearch" width="18" height="18" viewBox="0 0 18 18"><path d="M18 16.5l-5.14-5.18h-.35a7 7 0 10-1.19 1.19v.35L16.5 18l1.5-1.5zM12 7A5 5 0 112 7a5 5 0 0110 0z"></path></svg>
                    </button>
            </div>
        </div>
        <div>
            <br>
            <br>
        </div>


        <!--            :header-fields="headerFields"-->
        <!--:header-fields="pheaderfields"-->
        <!-- :header-fields="headerFields" -->
        <DataTable
            :table-title="tableTitle"
            :header-fields="headerFields"
            :sort-field="sortField"
            :sort="sort"
            :data="data || []"
            :initial-data="initialData"
            :is-loading="isLoading"
            :css="datatableCss"
            not-found-msg="Items not found"
            @on-update="dtUpdateSort"
            :track-by="trackBy"
        >
            <!-- Action button slot -->
            <template v-slot:actions="props">
                <!--
                <input type="button" class="btn btn-primary" value="Edit" @click="dtEditClick(props);">
                -->
                <b-button id="edit-btn" variant="primary" @click="$bvModal.show('bv-modal-example')">Edit</b-button>
            </template>
            <!-- Action link slot -->
            <template v-slot:actionFirst="props">
                <a href="#" @click.prevent="actionFirstClick(props)">Actions First</a>
            </template>

            <!-- custom header using boolean -->
            <template v-slot:[createHeaderName]>
                <span>Created Custom</span>
            </template>

            <!-- custom header usgin string -->
            <template v-slot:UpdatedHeader>
                <span>Updated Custom</span>
            </template>

            <!--
              Pagination component as a slot, but could be drag out from Database element
            -->
            <template v-slot:pagination>
                <Pagination
                    :page="currentPage"
                    :total-items="totalItems"
                    :items-per-page="itemsPerPage"
                    :css="paginationCss"
                    @on-update="changePage"
                    @update-current-page="updateCurrentPage"
                />
            </template>

            <!--
              ItemsPerPage component as a slot, but could be drag out from Database element
            -->
            <div class="items-per-page" slot="ItemsPerPage">
                <label>Items per page</label>
                <ItemsPerPageDropdown
                    :list-items-per-page="listItemsPerPage"
                    :items-per-page="itemsPerPage"
                    :css="itemsPerPageCss"
                    @on-update="updateItemsPerPage"
                />
            </div>

            <!-- Spinner element as slot used when is-loading attribute is true -->
            <Spinner slot="spinner"/>

            <!-- Custom element for description -->
            <div slot="DescriptionNew" slot-scope="props">
                <input
                    type="text"
                    :value="props.rowData.description"
                    @keyup="changeDescription($event, props.rowData.id)"
                    class="form-control"
                >
            </div>
        </DataTable>
    </div>
</template>


<script>
    import Spinner from "vue-simple-spinner";
    import { DataTable, ItemsPerPageDropdown, Pagination } from "v-datatable-light";
    import orderBy from "lodash.orderby";
    // This imports <b-modal> as well as the v-b-modal directive as a plugin:
    import { ModalPlugin, ButtonPlugin }  from "bootstrap-vue";
    Vue.use(ModalPlugin);
    Vue.use(ButtonPlugin);
    // import "bootstrap/dist/css/bootstrap.min.css";
    // import "bootstrap-vue/dist/bootstrap-vue.css";
    import Vue from 'vue';
    // import DialogeModal from "./DialogeModal";


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


    //var initialData = [];
    var workingData = [];

    export default {
        name: "DatatableLight",
        components: {
            DataTable,
            ItemsPerPageDropdown,
            Pagination,
            Spinner
        },
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
                type: String,
                required: true
            },
            initialItemsPerPage: {
                type: Number,
                required: false,
                default: 10
            },
            trackBy: {
                type: String,
                required: false,
                default: "none"
            }
            // ,
            // workingData: {
            //     type: Array,
            //     required: false
            // }
        },
        data: function() {
            workingData = JSON.parse(this.initialData);
            return {
                // access the csrf token from the view (meta information)
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                 headerFields:
//                    [
//                     "__slot:checkboxes",
//                     {
//                         name: "slug",
//                         label: "Slug",
//                         sortable: true
//                     },
//                     {
//                         name: "name",
//                         label: "Name",
//                         sortable: true
//                     },
//                     {
//                         name: "description",
//                         label: "Description",
//                         sortable: true,
//                         customElement: "DescriptionNew"
//                     },
//                     {
//                         name: "film_id",
//                         label: "FilmNr",
//                         sortable: true
//                     },
// // print current date
// //                     {
// //                         name: "created",
// //                         customHeader: true,
// //                         label: "Created",
// //                         sortable: true,
// //                         format: formatDate
// //                     },
//                     {
//                         name: "created_at",
//                         label: "Created",
//                         sortable: false
//                     },
//                     {
//                         name: "updated_at",
//                         label: "Updated",
//                         sortable: false
//                     },
//                     "__slot:actions:actionFirst",
//                     "__slot:actions"
//                ],

                data: workingData.slice(0, this.initialItemsPerPage),
                datatableCss: {
                    table: "table table-bordered table-hover table-striped table-center",
                    theadTh: "header-item",
                    thWrapper: "th-wrapper",
                    thWrapperCheckboxes: "th-wrapper checkboxes",
                    arrowsWrapper: "arrows-wrapper",
                    arrowUp: "arrow up",
                    arrowDown: "arrow down",
                    footer: "datatable-footer"
                },
                paginationCss: {
                    paginationItem: "pagination-item",
                    moveFirstPage: "move-first-page",
                    movePreviousPage: "move-previous-page",
                    moveNextPage: "move-next-page",
                    moveLastPage: "move-last-page",
                    pageBtn: "page-btn"
                },
                itemsPerPageCss: {
                    select: "item-per-page-dropdown"
                },
                isLoading: false,
                sort: "asc",
                sortField: "slug",
                listItemsPerPage: [5, 10, 20, 50, 100],
                itemsPerPage: this.initialItemsPerPage,
                currentPage: 1,
                //totalItems: function() { return workingData.length },
                totalItems: workingData.length,
                description: null,
                createHeaderName: "created:header"
            };
        },
        methods: {
            httpGet: function (Url, callbackMethod, responseStorage){
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                        var res = JSON.parse(xmlHttp.responseText);
                        callbackMethod( res, responseStorage );
                    }
                }
                xmlHttp.open("GET", Url, true); // true for asynchronous
                xmlHttp.send(null);
            },
            httpPost: function (Url, body, callbackMethod){
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                        var res = JSON.parse(xmlHttp.responseText);
                        callbackMethod( res );
                    }
                }
                xmlHttp.open("POST", Url, true); // true for asynchronous
                //xmlHttp.setRequestHeader("Accept", "application/json");
                xmlHttp.setRequestHeader("Accept","text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8");
                xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
                if (typeof csrfToken !== 'undefined' && csrfToken != null){
                    xmlHttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                    body = "_token=" + csrfToken + "&" + body;
                }
                xmlHttp.send( body);
            },
            processBackendResponse: function (response){
                //document.getElementById("container1").insertAdjacentHTML('beforeend', '<div>'+ JSON.stringify(response) + '</div>');
                // initialData = [];
                var newData = [];
                for (var key in response){
                    //console.log("iterate over response " + response[key].id + " " + response[key].slug);
                    //console.log("datatypes " + JSON.stringify(this.data) + " next " + JSON.stringify(this.newData) );
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
                workingData = newData;
                this.updateTableView();
                // this.totalItems = newData.length;
                // this.data = newData;

            },
            updateTableView: function(){
                this.totalItems = workingData.length;
                this.updateItemsPerPage(this.itemsPerPage);
                this.changePage(1);
            },
            dtEditClick: props => alert("Click props:" + JSON.stringify(props)),

            dtUpdateSort: function({ sortField, sort }) {
                const sortedData = orderBy(workingData, [sortField], [sort]);
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = this.currentPage * this.itemsPerPage;
                this.data = sortedData.slice(start, end);
            },

            updateItemsPerPage: function(itemsPerPage) {
                this.itemsPerPage = parseInt(itemsPerPage);
                if (this.itemsPerPage >= workingData.length) {
                    this.data = workingData;
                } else {
                    this.data = workingData.slice(0, this.itemsPerPage );
                }
            },

            changePage: function(currentPage) {
                this.currentPage = currentPage;
                const start = (currentPage - 1) * this.itemsPerPage;
                const end = currentPage * this.itemsPerPage;
                this.data = workingData.slice(start, end);
            },

            updateCurrentPage: function(currentPage) {
                this.currentPage = currentPage;
            },

            changeDescription: function(event, id) {
                this.data = this.data.map(item =>
                    item.id === id ? { ...item, description: event.target.value } : item
                );
            },

            actionFirstClick: params => {
                alert(JSON.stringify(params));
            },
            actionSearch: function (event){
                var searchString = document.getElementById('input-search').value;
                if (typeof searchString !== 'undefined' && searchString === ""){
                    if ( event.type === "keyup" && searchString === "" ){
                        this.updateUserInfo("info","Removing search filter.");
                        this.httpGet("list/actor", this.processBackendResponse);
                    } if ( event.type === "click" ){
                        this.updateUserInfo("warning","The search string must not be empty! Reseting Filter.");
                        this.httpGet("list/actor", this.processBackendResponse);
                    }

                } else {
                    this.updateUserInfo("info","Updating...");
                    this.httpPost("search/actor","q=" + searchString, this.processBackendResponse);
                }
                //document.getElementById('btn-search').addEventListener("click", this.actionSearch);
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
            this.processBackendResponse(workingData);
        },
        mounted() {
            //this.httpGet("list/actor", this.processBackendResponse);
            document.getElementById('input-search').addEventListener("keyup", this.actionSearch);
            document.getElementById('btn-search').addEventListener("click", this.actionSearch);

        }
    };
</script>


<style>

    /*
     default color was:
        color: #337ab7;
        instead of
        color: #00d1b2;
    */
    #datatable-light {
        font-family: "Avenir", Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #00b89c;
        margin-top: 60px;
    }

    #datatable-light .title {
        margin-bottom: 30px;
    }

    #datatable-light .items-per-page {
        height: 100%;
        display: flex;
        align-items: flex-start;
        color: #00d1b2;
    }

    #datatable-light .items-per-page label {
        margin: 0 15px;
    }

    /* Datatable CSS */
    .v-datatable-light .header-item {
        cursor: pointer;
        color: #00d1b2;
        transition: color 0.15s ease-in-out;
    }

    .v-datatable-light .header-item:hover {
        color: #ed9b19;
    }

    .v-datatable-light .header-item.no-sortable {
        cursor: default;
    }
    .v-datatable-light .header-item.no-sortable:hover {
        color: #00d1b2;
    }

    .v-datatable-light .header-item .th-wrapper {
        display: flex;
        width: 100%;
        height: 100%;
        font-weight: bold;
        align-items: center;
    }

    .v-datatable-light .header-item .th-wrapper.checkboxes {
        justify-content: center;
    }

    .v-datatable-light .header-item .th-wrapper .arrows-wrapper {
        display: flex;
        flex-direction: column;
        margin-left: 10px;
        justify-content: space-between;
    }

    .v-datatable-light .header-item .th-wrapper .arrows-wrapper.centralized {
        justify-content: center;
    }

    .v-datatable-light .arrow {
        transition: color 0.15s ease-in-out;
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
    }

    .v-datatable-light .arrow.up {
        border-bottom: 8px solid #00d1b2;
        margin-bottom: 5px;
    }

    .v-datatable-light .arrow.up:hover {
        border-bottom: 8px solid #ed9b19;
    }

    .v-datatable-light .arrow.down {
        border-top: 8px solid #00d1b2;
    }

    .v-datatable-light .arrow.down:hover {
        border-top: 8px solid #ed9b19;
    }
    /* example colorization of cells / rows / columns
    #datatable-light .v-datatable-light .row-1 .column-2 {
        color: green;
    }
    */


    .v-datatable-light .datatable-footer {
        display: flex;
        justify-content: space-between;
        width: 600px;
    }
    /* End Datatable CSS */

    /* Pagination CSS */
    .v-datatable-light-pagination {
        list-style: none;
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
        margin: 0;
        padding: 0;
        width: 300px;
        height: 30px;
    }

    .v-datatable-light-pagination .pagination-item {
        width: 30px;
        margin-right: 5px;
        font-size: 16px;
        transition: color 0.15s ease-in-out;
    }

    .v-datatable-light-pagination .pagination-item.selected {
        color: #ed9b19;
    }

    .v-datatable-light-pagination .pagination-item .page-btn {
        background-color: transparent;
        outline: none;
        border: none;
        color: #00d1b2;
        transition: color 0.15s ease-in-out;
    }

    .v-datatable-light-pagination .pagination-item .page-btn:hover {
        color: #ed9b19;
    }

    .v-datatable-light-pagination .pagination-item .page-btn:disabled {
        cursor: not-allowed;
        box-shadow: none;
        opacity: 0.65;
    }
    /* END PAGINATION CSS */

    /* ITEMS PER PAGE DROPDOWN CSS */
    .item-per-page-dropdown {
        background-color: transparent;
        min-height: 30px;
        border: 1px solid #00d1b2;
        border-radius: 5px;
        color: #00d1b2;
    }


    .item-per-page-dropdown:hover {
        cursor: pointer;
    }
    /* END ITEMS PER PAGE DROPDOWN CSS */

    #datatable-light .userInfo {
        float: left;
        padding: 6px;
        font-size: 17px;
    }

    #datatable-light .hidden{
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s 10s, opacity 10s linear;
    }

    #datatable-light .search-container {
        float: right;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-position: 10px 10px;
        background-repeat: no-repeat;
        background-color: white;
    }

    #datatable-light .search-container input[type=text] {
        padding: 6px;
        font-size: 17px;
        border: none;
    }

    #datatable-light .search-container button {
        float: right;
        padding: 6px 10px;
        background: #ddd;
        font-size: 17px;
        border: none;
        cursor: pointer;
    }

    #datatable-light .search-container button:hover {
        background: #ccc;
    }

    @media screen and (max-width: 600px) {
        #datatable-light .search-container .search-container {
            float: none;
        }
        #datatable-light a, #datatable-light .search-container input[type=text], #datatable-light .search-container button {
            float: none;
            display: block;
            text-align: left;
            width: 100%;
            margin: 0;
            padding: 14px;
        }
        #datatable-light .search-container input[type=text] {
            border: 1px solid #ccc;
        }
    }
</style>
