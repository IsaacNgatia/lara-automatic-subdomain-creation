(function () {
    "use strict";
    /* Start::Choices JS */
    document.addEventListener("DOMContentLoaded", function () {
        var genericExamples = document.querySelectorAll("[data-trigger]");
        for (let i = 0; i < genericExamples.length; ++i) {
            var element = genericExamples[i];
            new Choices(element, {
                allowHTML: false,
            });
        }
    });

    //define data
    var tabledata = [
        {
            id: 1,
            name: "Tiger Jackson",
            position: "System Designer",
            reference_number: "Sed at",
            mikrotik_name: "Sed at",
            reference_number: "Sed at",
            age: 41,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 2,
            name: "Vadett Summers",
            position: "UI Developer",
            reference_number: "Japan",
            mikrotik_name: "Japan",
            reference_number: "Japan",
            age: 28,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 3,
            name: "Lisbon Mox",
            position: "Junior Lecturer",
            reference_number: "San Deigo",
            mikrotik_name: "San Deigo",
            reference_number: "San Deigo",
            age: 45,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 4,
            name: "Medric Belly",
            position: "Javascrtarget_addresst Developer",
            reference_number: "Eden Gards",
            mikrotik_name: "Eden Gards",
            reference_number: "Eden Gards",
            age: 25,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 5,
            name: "Ayri Satovu",
            position: "Senior Engineer",
            reference_number: "Elitr stet",
            mikrotik_name: "Elitr stet",
            reference_number: "Elitr stet",
            age: 25,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 6,
            name: "Billie William",
            position: "Software Engineer",
            reference_number: "Paris",
            mikrotik_name: "Paris",
            reference_number: "Paris",
            age: 52,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 7,
            name: "Merrod Sailor",
            position: "Sales Assosiative",
            reference_number: "Sydney",
            mikrotik_name: "Sydney",
            reference_number: "Sydney",
            age: 35,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 8,
            name: "Khona David",
            position: "DBMS Engineer",
            reference_number: "France",
            mikrotik_name: "France",
            reference_number: "France",
            age: 25,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 9,
            name: "Coolio Hornet",
            position: "Angular Developer",
            reference_number: "Stet stet",
            mikrotik_name: "Stet stet",
            reference_number: "Stet stet",
            age: 39,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 10,
            name: "Sonia Fraust",
            position: "Software Developer",
            reference_number: "Magna lorem",
            mikrotik_name: "Magna lorem",
            reference_number: "Magna lorem",
            age: 32,
            status: "Inactive",
            expiry_date: "20-09-2024",
        },
        {
            id: 11,
            name: "Jennie Lora",
            position: "Bank Manager",
            reference_number: "UK",
            mikrotik_name: "UK",
            reference_number: "UK",
            age: 45,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 12,
            name: "Flynn Hank",
            position: "Cloud Developer",
            reference_number: "Mexico",
            mikrotik_name: "Mexico",
            reference_number: "Mexico",
            age: 25,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 13,
            name: "Ricky Martin",
            position: "React Developer",
            reference_number: "Sed sit",
            mikrotik_name: "Sed sit",
            reference_number: "Sed sit",
            age: 48,
            status: "Inactive",
            expiry_date: "20-09-2024",
        },
        {
            id: 14,
            name: "Halsey Kep",
            position: "Marketing Executive",
            reference_number: "Takimata sit",
            mikrotik_name: "Takimata sit",
            reference_number: "Takimata sit",
            age: 26,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 15,
            name: "Alaric Saltzman",
            position: "History Teacher",
            reference_number: "Mystic Falls",
            mikrotik_name: "Mystic Falls",
            reference_number: "Mystic Falls",
            age: 32,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 16,
            name: "Katherina Kat",
            position: "Event Planner",
            reference_number: "Accusam est",
            mikrotik_name: "Accusam est",
            reference_number: "Accusam est",
            age: 57,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 17,
            name: "Paulson Pal",
            position: "Data Analyst",
            reference_number: "Manchester",
            mikrotik_name: "Manchester",
            reference_number: "Manchester",
            age: 23,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 18,
            name: "Glory Sam",
            position: "System Administrator",
            reference_number: "Sit Invidunt",
            mikrotik_name: "Sit Invidunt",
            reference_number: "Sit Invidunt",
            age: 32,
            status: "Inactive",
            expiry_date: "20-09-2024",
        },
        {
            id: 19,
            name: "Bradley Cooper",
            position: "Civil Engineer",
            reference_number: "Aliquyam",
            mikrotik_name: "Aliquyam",
            reference_number: "Aliquyam",
            age: 26,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 20,
            name: "Keera Dsoa",
            position: "Cloud Developer",
            reference_number: "Sylvia",
            mikrotik_name: "Sylvia",
            reference_number: "Sylvia",
            age: 53,
            status: "Inactive",
            expiry_date: "20-09-2024",
        },
        {
            id: 21,
            name: "Alia Max",
            position: "Project Manager",
            reference_number: "Old York",
            mikrotik_name: "Old York",
            reference_number: "Old York",
            age: 26,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 22,
            name: "Yuri Gagarin",
            position: "Data Scientist",
            reference_number: "Sun",
            mikrotik_name: "Sun",
            reference_number: "Sun",
            age: 42,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 23,
            name: "cisaro Pals",
            position: "Sales Executive",
            reference_number: "Kambodia",
            mikrotik_name: "Kambodia",
            reference_number: "Kambodia",
            age: 25,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
        {
            id: 24,
            name: "Amberson Pet",
            position: "Sales Manager",
            reference_number: "Kidney",
            mikrotik_name: "Kidney",
            reference_number: "Kidney",
            age: 25,
            status: "Inactive",
            expiry_date: "20-09-2024",
        },
        {
            id: 25,
            name: "peter Parker",
            position: "Piolet",
            reference_number: "Web Spal",
            mikrotik_name: "Web Spal",
            reference_number: "Web Spal",
            age: 24,
            phone_number: "0712345678",
            billing_amount: 3000,
            phone_number: "0712345678",
            billing_cycle: "1 month",
            target_address: "12.234.43.52",
            max_download_speed: "3M/3M",
            status: "Active",
            expiry_date: "20-09-2024",
        },
    ];

    //Download Data from Tabulator
    //Build Tabulator
    var table = new Tabulator("#static-users-table", {
        width: 100,
        minWidth: 40,
        layout: "fitColumns",
        pagination: "local",
        paginationSize: 10,
        paginationSizeSelector: [5, 10, 15, 20, 25],
        paginationCounter: "rows",
        movableColumns: true,
        reactiveData: true, //turn on data reactivity
        data: tabledata, //load data into table
        columns: [
            { title: "Name", field: "name", sorter: "string" },
            { title: "Official Name", field: "name", sorter: "string" },
            {
                title: "Reference Number",
                field: "reference_number",
                sorter: "string",
            },
            {
                title: "Mikrotik Name",
                field: "mikrotik_name",
                sorter: "string",
            },
            {
                title: "Rate Limit",
                field: "max_download_speed",
                sorter: "string",
            },
            { title: "Ip", field: "target_address", sorter: "number" },
            {
                title: "Phone Number",
                field: "phone_number",
                sorter: "number",
            },
            {
                title: "Bill",
                field: "billing_amount",
                sorter: "number",
            },
            {
                title: "Billing Cycle",
                field: "billing_cycle",
                sorter: "string",
            },
            { title: "Status", field: "status", sorter: "string" },
            { title: "Expiry Date", field: "expiry_date", sorter: "string" },
        ],
    });

    //trigger download of data.csv file
    document
        .getElementById("download-csv")
        .addEventListener("click", function () {
            table.download("csv", "data.csv");
        });

    //trigger download of data.json file
    document
        .getElementById("download-json")
        .addEventListener("click", function () {
            table.download("json", "data.json");
        });

    //trigger download of data.xlsx file
    document
        .getElementById("download-xlsx")
        .addEventListener("click", function () {
            table.download("xlsx", "data.xlsx", { sheetName: "My Data" });
        });

    //trigger download of data.pdf file
    document
        .getElementById("download-pdf")
        .addEventListener("click", function () {
            table.download("pdf", "data.pdf", {
                orientation: "portrait", //set page orientation to portrait
                title: "Example Report", //add title to report
            });
        });

    //trigger download of data.html file
    document
        .getElementById("download-html")
        .addEventListener("click", function () {
            table.download("html", "data.html", { style: true });
        });

    document.querySelector("#switcher-rtl").addEventListener("click", () => {
        document.querySelectorAll(".tabulator").forEach((ele) => {
            ele.classList.add("tabulator-rtl");
        });
    });

    document.querySelector("#switcher-ltr").addEventListener("click", () => {
        document.querySelectorAll(".tabulator").forEach((ele) => {
            ele.classList.remove("tabulator-rtl");
        });
    });

    document.querySelector("#reset-all").addEventListener("click", () => {
        document.querySelectorAll(".tabulator").forEach((ele) => {
            ele.classList.remove("tabulator-rtl");
        });
    });
})();
