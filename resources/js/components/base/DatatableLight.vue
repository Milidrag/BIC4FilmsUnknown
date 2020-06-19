<template>
    <div id="datatable-light">

        <DataTable
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
            <template v-slot:actionsEditInline="props">
                <!--
                <input type="button" class="btn btn-primary" value="Edit" @click="dtEditClick(props);">
                -->
                <!--
                <b-button id="edit-btn" variant="primary" @click="$bvModal.show('bv-modal-example')">Edit</b-button>
                -->
                <b-button id="edit-btn" variant="primary" @click="dtButtonControl($event, props)">Edit</b-button>
            </template>

            <template v-slot:actionEditSeperat="props">
                <!--            <b-button id="edit-btn-seperate" variant="primary" v-bind:href="entryUrl + ''+ props.rowData[identifierOfEntry] + '/edit'" >Edit extra</b-button>-->
                <b-button id="edit-btn-seperate" variant="primary" @click="dtButtonControl($event, props)">Edit extra
                </b-button>
            </template>

            <!-- Action remove slot -->
            <template v-slot:actionRemove="props">
                <b-button id="remove-btn" variant="danger" @click="dtButtonControl($event, props)">Remove</b-button>
            </template>
            s
            <!-- Action "Show Details" slot -->
            <template v-slot:actionShowDetails="props">
                <!--            <b-button id="details-btn" v-bindef:hr="entryUrl + ''+ props.rowData[identifierOfEntry]" variant="primary" @click="dtButtonControl($event, props)">Details</b-button>-->
                <b-button id="details-btn" variant="primary" @click="dtButtonControl($event, props)">Details</b-button>
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
    import {DataTable, ItemsPerPageDropdown, Pagination} from "v-datatable-light";
    import orderBy from "lodash.orderby";

    var workingData = [];

    export default {
        name: "DatatableLight",
        components: {
            DataTable,
            ItemsPerPageDropdown,
            Pagination,
            Spinner
        },
        props: {
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
            initialItemsPerPage: {
                type: Number,
                required: false,
                default: 10
            },
            // unique column
            trackBy: {
                type: String,
                required: false,
                default: "none"
            },
            // url to use to update / delete a table entry
            entryUrl: {
                type: String,
                required: true,
                default: "actor/"
            },
            // // table row contains multiple attributes which of them should be used to update an entry e.g. /actor/{slug}
            // identifierOfEntry:{
            //     type: String,
            //     required: true,
            //     default: "slug"
            // },
            // function is called when form was submitted ( e.g. parent)
            dtButtonControl: {
                type: Function,
                required: false,
                default: function () {

                }
            },
        },
        data: function () {
            workingData = this.initialData;

            return {
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
                totalItems: workingData.length,
                description: null,
                createHeaderName: "created:header",
            }
        },

        computed: {},
        watch: {
            // runs when parent changes its data
            initialData: {
                handler: function (newData, oldData) {
                    this.isLoading = true;
                    workingData = newData;
                    this.updateTableView();
                },
                deep: true
            }
        },
        methods: {
            changeDescription: function (event, id) {
                this.data = this.data.map(item =>
                    item.id === id ? {...item, description: event.target.value} : item
                );
            },
            changePage: function (currentPage) {
                this.currentPage = currentPage;
                const start = (currentPage - 1) * this.itemsPerPage;
                const end = currentPage * this.itemsPerPage;
                this.data = workingData.slice(start, end);
            },
            // dtDetailsClick: function (props) {
            //     // redirect to url via javascript
            //     window.location.href = this.entryUrl + props.rowData[this.identifierOfEntry];
            // },
            // dtEditClick: function (props) {
            //     /*
            //     window.location.href = "http://localhost:8000/public/actor/"+slug+"/edit";
            //                      */
            //     this.formData = {};
            //     this.formData = props.rowData;
            //     this.$bvModal.show("edit-form-dialog");
            //
            // },
            // dtRemoveClick: function (props) {
            //     // alert("Click props:" + JSON.stringify(props) );
            //
            //
            //     axios.delete(this.entryUrl + props['rowData'][this.identifierOfEntry])
            //         .then(response => {
            //             const deletedItem = workingData.find((entry) => {
            //                 // find the deleted element
            //                 return entry.slug === props['rowData'][this.identifierOfEntry];
            //             })
            //             if (~deletedItem) {// if the item exists in array
            //                 workingData.splice(workingData.indexOf(deletedItem), 1) //delete the row
            //                 this.updateTableView(); // update the view
            //             }
            //         }).catch((error) => {
            //         this.dialogFailedCallback();
            //     });
            // },
            dtUpdateSort: function ({sortField, sort}) {
                const sortedData = orderBy(workingData, [sortField], [sort]);
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = this.currentPage * this.itemsPerPage;
                this.data = sortedData.slice(start, end);
            },
            updateCurrentPage: function (currentPage) {
                this.currentPage = currentPage;
            },
            updateItemsPerPage: function (itemsPerPage) {
                this.itemsPerPage = parseInt(itemsPerPage);
                if (this.itemsPerPage >= workingData.length) {
                    this.data = workingData;
                } else {
                    this.data = workingData.slice(0, this.itemsPerPage);
                }
            },
            updateTableView: function () {
                this.totalItems = workingData.length;
                this.updateItemsPerPage(this.itemsPerPage);
                this.changePage(this.currentPage);
                this.isLoading = false;
            },
        }
    }
</script>

<style>
    /*
     default color was:
        color: #337ab7;
        instead of
        color: #00d1b2;
    */
    #datatable-light {
        /*font-family: "Avenir", Helvetica, Arial, sans-serif;*/
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

    b {
        /*font-family: Helvetica;*/
        color: #222222;
        padding: 0px;
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


</style>
