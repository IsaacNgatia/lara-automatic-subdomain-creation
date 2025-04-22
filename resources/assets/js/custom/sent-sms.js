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
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Elit laboris anim aliqua do irure dolor nostrud aliquip cupidatat voluptate fugiat id. Occaecat Lorem quis aliqua elit enim ex aliquip ex. Non nulla laboris amet officia excepteur eiusmod labore ullamco.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 2,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Et cillum ex veniam amet voluptate enim. Nulla laborum qui minim et adipisicing magna irure deserunt enim do dolor. Officia mollit exercitation aute ut laborum adipisicing. Cillum deserunt laboris consectetur consectetur dolor enim deserunt reprehenderit consectetur elit. Duis veniam ullamco consectetur quis. Et reprehenderit proident sunt labore eiusmod laboris ullamco veniam est aute.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 3,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Aliqua dolore pariatur occaecat veniam anim nisi officia ea occaecat. Reprehenderit elit commodo labore ullamco ullamco proident sit esse velit elit aute consectetur. Nulla eu sunt laborum laborum enim in consequat ut minim laborum enim culpa nostrud quis. Laborum enim sit sunt amet velit in cupidatat aliquip reprehenderit ex ut dolore.",
            message_id: "fdv-dbgfvx-123-453",
            age: 45,
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 4,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Dolor do eiusmod ut ea. Est exercitation id dolor quis anim in dolor irure non. Proident id non anim nisi eu esse.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 5,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Voluptate excepteur sit esse id dolor quis aute dolor magna culpa ut eiusmod quis velit. Proident ipsum reprehenderit cillum incididunt labore adipisicing labore magna commodo fugiat. Irure cillum eu ex ad laborum cillum adipisicing aute fugiat et dolore.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 6,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Exercitation ut sit cillum quis tempor nulla. Anim incididunt aliquip fugiat et pariatur. Minim voluptate aliquip est eu id reprehenderit. Occaecat cupidatat id laboris consequat ex mollit dolore nisi eu sit reprehenderit ex aute. Do exercitation cupidatat duis ad adipisicing eiusmod labore. Ullamco voluptate ea veniam duis pariatur proident velit consequat cupidatat excepteur proident dolor nisi. Tempor quis consequat ex nulla ullamco velit labore quis.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 7,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Adipisicing ut fugiat eiusmod magna eiusmod ex dolor anim officia amet officia nisi excepteur. Id occaecat ad reprehenderit nostrud laborum deserunt voluptate eu ullamco consequat nostrud amet. Tempor excepteur sint cupidatat magna sunt nulla Lorem enim nulla sint in enim sunt. Elit sunt occaecat Lorem pariatur do eiusmod veniam qui reprehenderit aute laboris veniam. Elit quis magna fugiat ex sunt est sit Lorem sunt laborum commodo commodo sunt nulla. Sunt ut ut voluptate nulla in.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 8,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Ullamco ullamco enim esse consequat dolor Lorem. Exercitation nulla pariatur ullamco magna mollit aliqua id duis exercitation velit aliqua tempor deserunt ad. Amet qui laborum dolore officia tempor tempor dolor. Do est exercitation do quis in ea magna irure adipisicing pariatur. Sit excepteur eu amet in. Consectetur nisi laboris eiusmod nulla aliquip.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 9,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Sunt ad proident id veniam irure ea laboris cupidatat Lorem. Et in eu anim culpa officia quis qui esse enim anim est. Esse laborum ex qui in ad dolore Lorem cupidatat ut dolore veniam proident ad. Duis reprehenderit qui laboris dolor est voluptate officia veniam eu occaecat magna consectetur. Ad eiusmod enim adipisicing adipisicing enim nostrud officia nostrud. Aute cupidatat mollit qui duis proident fugiat cillum consectetur duis nisi tempor. Duis amet reprehenderit non elit irure minim Lorem cupidatat fugiat id velit cupidatat.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 10,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Nulla eu eiusmod deserunt duis. Pariatur sunt adipisicing anim nulla pariatur enim enim. Aute et enim sunt deserunt aliquip. Reprehenderit nisi occaecat ut nisi proident esse mollit exercitation eiusmod irure cupidatat. Laboris velit elit veniam ea qui est consequat ex do. Tempor labore pariatur mollit sunt exercitation nostrud anim reprehenderit commodo cupidatat elit proident sint nostrud.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 11,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Labore officia voluptate laboris aliqua commodo anim sit ex enim tempor excepteur ex irure ex. Amet nostrud tempor elit labore sint elit officia elit voluptate quis proident mollit. Magna proident sunt aliquip sit cupidatat enim laborum anim eiusmod veniam irure. In laboris deserunt cillum magna elit nulla irure sunt laboris tempor sunt aute. Fugiat velit labore veniam voluptate aute qui do quis ipsum est exercitation aute ipsum. Eiusmod cupidatat id dolore veniam ipsum sunt commodo velit. Ea adipisicing aliqua eiusmod sunt ut reprehenderit quis.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 12,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Ex fugiat duis officia nulla ullamco ut eu aliqua nisi aliqua veniam elit cupidatat mollit. Cillum fugiat aute labore fugiat irure quis qui labore. Reprehenderit deserunt consectetur aliquip qui deserunt excepteur culpa sunt pariatur duis.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 13,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Incididunt cupidatat quis aliqua laboris consequat Lorem aliquip. Eiusmod ipsum irure eiusmod sunt qui adipisicing nisi aliqua nostrud nisi elit. Aute qui sit dolore sit ad duis voluptate laboris. Cupidatat magna Lorem eiusmod nisi aute incididunt labore voluptate incididunt incididunt. Qui ad amet cillum elit deserunt velit proident consequat eu.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 14,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Minim ex mollit exercitation exercitation officia exercitation est ut anim cillum elit voluptate. Velit dolor id qui eiusmod esse nulla fugiat. Aliqua et ex esse ut dolor aliqua eu dolor Lorem quis.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 15,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Velit minim proident veniam dolore tempor veniam ullamco cupidatat esse pariatur. Tempor fugiat nisi commodo nostrud culpa ullamco enim ad amet proident Lorem. Sint mollit non incididunt eu velit quis qui id dolor non deserunt incididunt. Ipsum incididunt pariatur laborum sit consectetur cillum aliquip. Excepteur labore tempor labore voluptate officia id occaecat nostrud aliquip non deserunt.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 16,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Magna occaecat commodo enim minim irure deserunt ullamco cillum aliqua voluptate. Ex reprehenderit commodo culpa amet ex quis reprehenderit labore commodo. Fugiat consequat aliqua tempor ad aute. Minim exercitation aliqua tempor proident ea consectetur incididunt duis commodo magna consectetur. Sunt id exercitation esse amet cillum ea. Magna occaecat sint aliqua est ipsum elit proident irure veniam.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 17,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Irure dolore exercitation qui consectetur. Commodo laborum commodo dolore velit nisi non. Irure adipisicing in veniam proident nostrud in nostrud magna consectetur. Velit dolor anim fugiat elit consectetur cupidatat enim excepteur incididunt. Esse pariatur ad aute qui nulla incididunt irure pariatur laborum occaecat quis occaecat. Consequat ipsum consectetur velit ullamco veniam ipsum incididunt veniam do cupidatat id. Reprehenderit dolore exercitation sint amet laborum commodo aliquip officia.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 18,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Ex esse velit ut proident consequat. Sunt sunt proident anim deserunt irure eiusmod pariatur proident mollit elit. Id ut dolor nulla incididunt ea nisi et cupidatat aliquip officia id sint eu dolor. Aliquip eu enim consectetur ut voluptate. Tempor eiusmod sunt adipisicing ut amet magna occaecat velit ut magna enim irure mollit. Anim incididunt id ex dolore excepteur.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 19,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Nulla esse nisi laboris occaecat do exercitation. Officia occaecat anim nisi proident voluptate aliquip non cillum labore. Proident mollit anim enim et cupidatat ut nostrud proident adipisicing sit laborum sunt id. Elit irure aute reprehenderit velit consequat commodo id laboris sit reprehenderit et sint eiusmod. Est in proident ipsum culpa consectetur exercitation do in ipsum non elit cillum.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 20,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Aliqua elit qui nulla reprehenderit do eiusmod laborum minim eiusmod sint nisi labore. Anim consequat culpa laborum anim pariatur deserunt exercitation nostrud labore minim sint proident aliquip. Irure nulla tempor ullamco aliqua tempor sint laboris reprehenderit proident magna deserunt excepteur exercitation. Ad voluptate cillum labore exercitation ullamco laborum. Sint duis adipisicing officia ea velit aliquip tempor mollit cillum proident. Voluptate consequat ipsum Lorem consectetur aute nostrud consectetur est aliquip.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 21,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Cupidatat culpa velit adipisicing et ea eu qui ullamco commodo consequat irure ad. Nulla dolore eu velit in. Qui ut eu sunt eu duis sit sit laborum nisi. Dolore in proident ipsum et enim eu non laboris nostrud quis eiusmod. Eu non voluptate ullamco proident sit minim enim.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 22,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Ea cupidatat aliqua officia consectetur ipsum. Lorem anim velit ex ut nostrud eu. Esse nulla quis est ullamco magna dolore elit reprehenderit. Occaecat nulla voluptate culpa irure labore exercitation.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 23,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Ad in ut pariatur non pariatur ipsum minim deserunt sunt proident reprehenderit laborum. Proident deserunt do aute culpa nulla do minim pariatur quis reprehenderit consectetur dolore cillum. Incididunt mollit aliqua laborum voluptate labore incididunt non consectetur laboris eu et ea aute. Ut aliqua proident adipisicing consectetur fugiat quis veniam eu ex do. Et nulla cillum excepteur nostrud.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 24,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Officia dolore ea Lorem incididunt. Cillum et dolore dolore labore veniam Lorem excepteur ullamco. Non excepteur laborum laborum et anim.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
        {
            id: 25,
            is_sent: "SUCCESS",
            recipient: "+254712345678",
            message:
                "Exercitation in ex deserunt elit est ex dolore sunt qui duis. Mollit sit labore nulla incididunt id minim sunt sint minim sit deserunt consectetur aliqua do. Officia qui nulla labore ullamco eu occaecat in adipisicing aliquip dolor aliqua consequat. Sint voluptate sit ex tempor elit deserunt aliquip. Do mollit ea tempor in sint exercitation commodo. Commodo ipsum minim minim dolor exercitation sint ad ad est.",
            message_id: "fdv-dbgfvx-123-453",
            subject: "Acknowledgement Message",
            created_at: "2024-06-20 16:40:23",
        },
    ];
    //Download Data from Tabulator
    //Build Tabulator
    var table = new Tabulator("#sent-sms", {
        width: 100,
        minWidth: 40,
        layout: "fitColumns",
        pagination: "local",
        paginationSize: 10,
        paginationSizeSelector: [5, 10, 15, 20, 25],
        paginationCounter: "rows",
        movableColumns: true,
        responsiveLayout: "collapse",
        // responsiveLayoutCollapseStartOpen: true,
        // rowHeader: {
        //     formatter: "responsiveCollapse",
        //     width: 30,
        //     minWidth: 30,
        //     hozAlign: "center",
        //     resizable: false,
        //     headerSort: false,
        // },

        reactiveData: true, //turn on data reactivity
        data: tabledata, //load data into table
        columns: [
            { title: "Id", field: "id", sorter: "number", width: 90 },
            {
                title: "Status",
                field: "is_sent",
                sorter: "string",
                width: 120,
            },
            {
                title: "Number",
                field: "recipient",
                sorter: "string",
                width: 150,
            },
            {
                title: "Message",
                field: "message",
                sorter: "string",
                minWidth: 600,
                widthGrow: 3,
            },
            {
                title: "Subject",
                field: "subject",
                sorter: "string",
                minWidth: 200,
            },
            {
                title: "Message Id",
                field: "message_id",
                sorter: "string",
                minWidth: 175,
            },
            {
                title: "Delievred At",
                field: "created_at",
                sorter: "number",
                minWidth: 200,
            },
        ],
    });
})();
