<style>
    .table-responsive {
        overflow-y: clip !important;

    }

    .btn-insoft {
        font-size: 10px;
        padding: 5px 8px;
        border-radius: 17px;
    }

    .user-image {
        width: 60px;
        height: 63px;
        border-radius: 10px;
        padding: 3px;
        background: cadetblue;
    }

    .lead-image {
        width: 40px;
        height: 43px;
        border-radius: 6px;
        padding: 3px;
        background: rgb(113, 175, 177);
    }

    .branch-title {
        font-size: 17px;
        font-weight: bold;
        color: red;
    }

    .required::after {
        content: " *";
        color: red;
    }

    .select2-container--default .select2-selection--single {
        height: 40px;
        /* sesuaikan */
        padding: 7px 14px;
        border: 1px solid #ebebeb !important;

    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
        /* biar text center */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 34px;
    }

    .card-color {
        background: #edffea !important
    }


    .table {
        font-size: 12px;
    }

    .table th,
    .table td {
        padding: 4px 8px;
    }

    .tombol {
        cursor: pointer;

    }

    .tombol:hover {
        border: 1px solid red;
        background: black !important;
        color: white;
    }

    .text-edit {
        cursor: pointer;
        color: orange;
    }

    .text-edit:hover {
        color: blue;
    }

    .text-delete {
        cursor: pointer;
        color: red;
    }

    .text-delete:hover {
        color: blue;
    }

    .chat-status {
        position: relative;
        top: -14px;
        padding: 7px;
        left: 163px;
        font-size: 8px;
    }

    .custom-badge-number {
        background: orangered;
        padding: 3px 8px;
        font-size: 10px;
        color: white;
        border-radius: 7px;
        position: relative;
        top: 20px;
        right: -17px;
    }

    .btn-3-chat {
        position: relative;
        top: 30px;
    }

    .dropdown-chat ul {
        font-size: 13px;
        background: #dcffee;
        color: white !important;
    }

    .chat-item:hover {
        background: #f5f6f6 !important;
    }

    .dropdown-menu {
        border: none;
        border-radius: 12px;
    }

    .dropdown-item {
        font-size: 14px;
        padding: 10px 14px;
    }

    .inbox-wrapper {
        margin-top: -86px !important;
    }

    .msg-actions {
        position: absolute;
        top: 6px;
        right: 6px;
        display: none;
        z-index: 10;
    }

    .msg-wrapper:hover .msg-actions {
        display: block;
    }

    .msg-menu-btn {
        border: none;
        background: orange;
        color: white;
        padding: 4px 5px;
        position: relative;
        right: -16px;
        border-radius: 16px;
        font-size: 11px;
    }

    .reply-box {
        background: rgba(0, 0, 0, 0.05);
        border-left: 3px solid #00a884;
        border-radius: 6px;
        padding: 5px 8px;
        margin-bottom: 6px;
        font-size: 12px;
    }

    .reply-name {
        font-weight: 600;
        color: #00a884;
        margin-bottom: 2px;
    }

    .dropdown-menu-chat {
        min-width: 130px;
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .12);
    }

    .chat-bubble {
        position: relative;
    }

    .reaction-trigger {
        position: absolute;
        top: -1px;
        right: -49px;
        opacity: 0;
        transition: .15s;
        cursor: pointer;
        font-size: 22px;
        color: grey !important;
    }

    .msg-wrapper:hover .reaction-trigger {
        opacity: 1;
    }

    .reaction-picker {
        position: absolute;
        bottom: 24px;
        right: 0;

        background: white;
        border-radius: 30px;
        padding: 6px 10px;

        display: flex;
        gap: 8px;

        box-shadow: 0 2px 12px rgba(0, 0, 0, .15);
        z-index: 999;

        opacity: 0;
        visibility: hidden;
        pointer-events: none;

        transition: .15s;
    }

    .reaction-trigger:hover .reaction-picker,
    .reaction-picker:hover {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }


    .reaction-picker span {
        font-size: 18px;
        cursor: pointer;
        transition: .15s;
    }

    .reaction-picker span:hover {
        transform: scale(1.25);
    }

    .reaction-container {
        margin-top: 2px;
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }

    .reaction-badge {
        background: white;
        border: 1px solid #e9edef;
        border-radius: 12px;
        padding: 1px 6px;
        font-size: 12px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
    }

    .reaction-left {
        left: -35px !important;
    }

    .picker-left {
        left: 0;
        bottom: 32px;
        right: auto;
    }
</style>
