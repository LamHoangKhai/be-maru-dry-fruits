import { Mydebounce, loading } from "../function.js";
import { loadProduct } from "./load-data.js";
import { modalHtml } from "./modal-order-detail.js";
//  call api Search

$(document).ready(() => {
    let storage = {
        search: "",
        page: 1,
        take: 25,
        totalData: 0,
        totalPage: 1,
        select: 0,
        url: $("#url").data("url"),
        tableCols: 9,
    };
    //handle search
    $("#search").keypress(
        Mydebounce((e) => {
            if (e.keyCode === 13) {
                return 0;
            }
            storage.search = e.target.value;
            storage.page = 1;
            loading(storage.tableCols);
            $("#pagination").simplePaginator("changePage", 1);
        }, 500)
    );

    $("#search").bind("paste", (e) => {
        // access the clipboard using the api
        storage.search = e.originalEvent.clipboardData.getData("text");
        storage.page = 1;
        loading(storage.tableCols);
        $("#pagination").simplePaginator("changePage", 1);
    });

    $("#search").keyup(
        Mydebounce((e) => {
            if (e.keyCode === 8) {
                storage.search = e.target.value;
                storage.page = 1;
                loading(storage.tableCols);
                $("#pagination").simplePaginator("changePage", 1);
            }
            return 0;
        }, 500)
    );
    // end handle search

    //handle select
    $("#select").change((e) => {
        storage.select = e.target.value;
        loading(storage.tableCols);
        $("#pagination").simplePaginator("changePage", 1);
    });

    //end handle select

    // load pagination
    $("#pagination").simplePaginator({
        totalPages: 1,
        maxButtonsVisible: 10,
        currentPage: 1,
        nextLabel: "next",
        prevLabel: "prev",
        firstLabel: "first",
        lastLabel: "last",
        clickCurrentPage: true,
        pageChange: function (page) {
            storage.page = parseInt(page);
            this.currentPage = storage.page;
            loading(storage.tableCols);
            loadProduct(storage);
        },
    });
    // end pagination

    $("#table").on("click", ".detail", (e) => {
        let urlDetail = $("#url-detail").data("url");
        let orderId = $(e.target).parent().data("id");
        $.ajax({
            type: "POST",
            url: urlDetail,
            data: { id: orderId },
            dataType: "json",
            success: (res) => {
                let data = res.data || [];
                $("#modalOrderDetail").modal("show");
                modalHtml(data);
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });

    $("#modalOrderDetail").on("click", "#closeModal", (e) => {
        $("#modalOrderDetail").modal("toggle");
    });

    $("#modalOrderDetail").on("click", "#confirm", (e) => {
        const urlUpdateStatus = $("#url-update-status").data("url");
        let orderId = e.target.value;
        $.ajax({
            type: "POST",
            url: urlUpdateStatus,
            data: { id: orderId },
            dataType: "json",
            success: (res) => {
                $("#modalOrderDetail").modal("toggle");
                loading(storage.tableCols);
                $("#pagination").simplePaginator("changePage", 1);
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });

    $("#modalOrderDetail").on("click", "#cancel", (e) => {
        const urlCancel = $("#url-cancel").data("url");
        let orderId = e.target.value;
        $.ajax({
            type: "POST",
            url: urlCancel,
            data: { id: orderId },
            dataType: "json",
            success: (res) => {
                $("#modalOrderDetail").modal("toggle");
                loading(storage.tableCols);
                $("#pagination").simplePaginator("changePage", 1);
            },
            error: function (error) {
                console.log(error.message);
            },
        });
    });
});
