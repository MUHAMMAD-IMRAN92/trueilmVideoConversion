<style>
    /*================================================================================
 Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
 Version: 2.0
 Author: PIXINVENT
 Author URL: http://www.themeforest.net/user/pixinvent
================================================================================

NOTE:
------
PLACE HERE YOUR OWN SCSS CODES AND IF NEEDED, OVERRIDE THE STYLES FROM THE OTHER STYLESHEETS.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR STYLES IT'S BETTER LIKE THIS.  */
    #login-body {
        background-image: url(../../app-assets/images/backgrounds/4.jpg);
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover
    }

    #project-name {
        font-size: 26px;
        font-weight: bold;
        color: black;
    }

    .email-label {
        font-size: 13px;
        font-weight: bold;
        /* color: black; */
    }

    .password-label {
        font-size: 13px;
        font-weight: bold;
        /* color: black; */
    }

    .offset-md-4 {
        margin-left: 40%;
    }

    #login-text {
        font-size: 18px;
        font-weight: bold;
    }

    #tippy-1 {
        display: none;
    }

    .add-brand-font {
        font-size: 13px;
    }

    .table-images {
        width: 100px;
        height: 70px;
    }

    .description-td {
        width: 34% !important;
    }

    .d-flex {
        display: flex;
    }

    input[type="file"] {
        display: block;
    }

    .imageThumb {
        height: 120px !important;
        width: 160px !important;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 20px 20px 0 0;
        margin-left: 10px;
    }

    .remove {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }

    .remove:hover {
        background: white;
        color: black;
    }

    body {
        font-family: sans-serif;
        background-color: #eeeeee;
    }

    .file-upload {
        background-color: #ffffff;
        width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;

        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 2px solid #141414;
        position: relative;
        border-radius: 4px;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #dadada90;
        border: 4px solid #141414;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #141414;
        padding: 60px 0;
    }

    .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
    }

    .product-title-td {
        width: 20rem !important;
    }

    .note-editor .note-toolbar .note-color .dropdown-toggle,
    .note-popover .popover-content .note-color .dropdown-toggle {
        width: 30px !important;
    }

    .card .card-header {
        justify-content: unset !important;
    }

    .btn-light,
    .custom-lightbtn {
        border-color: 1px solid #dddddd !important;
        background: white !important;
        color: black !important;
        border: 1px solid #dddddd !important;
        border-radius: 0 !important;
        font-size: 14px !important;
        line-height: 1.5 !important;
        border-radius: 3px !important;
    }

    .vendorProductInput {
        width: 100px;
        margin-left: 4px;
        margin-right: 10px;
        border-color: #d9d9d9;
        border-radius: 2px
    }

    #vendor-products-configration td:last-child {
        -webkit-box-sizing: content-box;
        box-sizing: content-box;
        display: flex;
    }

    #vendor-products-configration td:last-child input,
    #vendor-products-configration td:last-child p {
        margin: 0 5px;
    }

    .td-img {
        width: 50px;
        height: 50px;
    }

    .card-height {
        max-height: 600px;
        overflow-y: scroll;
        overflow-y: auto;
    }

    .left-to-right {
        text-align: right;
        margin-right: 20px
    }

    /* .match-height{
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }
    .ayat-insert,.ayat-data{
        flex-grow: 1 !important;
    } */
    /*
    For chat
    */
    #chat2 .form-control {
        border-color: transparent;
    }

    #chat2 .form-control:focus {
        border-color: transparent;
        box-shadow: inset 0px 0px 0px 1px transparent;
    }

    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    /*.rating start*/


    </style>
