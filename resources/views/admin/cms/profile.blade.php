@extends('layouts.app')

@section('content')
    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #134a68
        }

        .profile-button {
            background: #134a68;
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #0c3348
        }

        .profile-button:focus {
            background: #134a68;
            box-shadow: none
        }

        .profile-button:active {
            background: #134a68;
            box-shadow: none
        }

        .back:hover {
            color: #rgb(19, 74, 104);
            cursor: pointer
        }

        .text-field {
            position: relative;
            margin: 10px 2.5px 20px 2.5px;
        }

        .text-field input {
            display: inline-block;
            /* border-bottom: solid medium #999; */


            color: white;
            border: 0px solid #047ec0c9;
            border-bottom: 2px solid #047ec0c9;
            border-left: 1px solid #047ec0c9;
            background-color: rgba(255, 255, 255, 0);
            padding: 10px 10px 10px 10px;
            border-top-left-radius: 14px;
            border-top-right-radius: 12px;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 14px;


        }

        form-control:disabled,
        .form-control[readonly] {
            background-color: transparent !important;
            opacity: 1;
        }

        .text-field input:focus {
            color: white;
            background: #54617021 !important;
            border: 0px solid #fcfcfca1;
            border-bottom: 2px solid #fcfcfca1;
            border-left: 1px solid #fcfcfca1;
            padding: 10px 10px 10px 10px;
            border-top-left-radius: 14px;
            border-top-right-radius: 12px;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 14px;
        }

        .text-field textarea {
            display: inline-block;
            /* border-bottom: solid medium #999; */


            color: white;
            border: 0px solid #047ec0c9;
            border-bottom: 2px solid #047ec0c9;
            border-left: 1px solid #047ec0c9;
            background-color: rgba(255, 255, 255, 0);
            padding: 10px 10px 10px 10px;
            border-top-left-radius: 14px;
            border-top-right-radius: 12px;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 14px;
        }

        .text-field textarea:focus {
            color: white;
            background: #0c315d24 !important;
            border: 0px solid #fcfcfca1;
            border-bottom: 2px solid #fcfcfca1;
            border-left: 1px solid #fcfcfca1;
            padding: 10px 10px 10px 10px;
            border-top-left-radius: 14px;
            border-top-right-radius: 12px;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 14px;
        }

        label {
            color: #999;
            position: absolute;
            pointer-events: none;
            left: 10px;
            top: 10%;
            transition: 0.2s;
        }

        .labell {
            top: -15px;
            left: -3px;
            font-size: small;
            color: #ffffff;
            background-color: transparent;
            padding: 0 5px 0 5px;
        }





        /* input:focus~label,
                                                                                input:valid~label {
                                                                                    top: -10px;
                                                                                    left: 15px;
                                                                                    font-size: small;
                                                                                    color: #13547a;
                                                                                    background-color: #fff;
                                                                                    padding: 0 5px 0 5px;
                                                                                } */

        input:focus~label,
        input:valid~label {
            top: -15px;
            left: -3px;
            font-size: small;
            color: #ffffff;
            background-color: transparent;
            padding: 0 5px 0 5px;
        }








        .bck {
            /* background-image: linear-gradient(121deg, #13547a 1%, #80d0c7 250%); */
            /* background-image: linear-gradient(121deg, #111d48f5 1%, #80d0c7 250%); */
            background-image: linear-gradient(199deg, #111d48f5 1%, #80d0c7 250%);

        }

        .parent {
            position: relative;

        }

        .child {

            position: absolute;
            top: 0;
            left: 0;
        }

        .spanchild {

            position: absolute;
            top: 0%;
            left: 39%;
        }

        .child1 {

            position: absolute;
            top: 27%;
            left: 38%;

        }

        .dpbtn {
            background: #ffffff;
            /* Green */
            border: none;
            color: rgb(0, 90, 119);
            padding: 3%;
            text-align: center;
            display: inline-block;
            margin: 3px 3px;
            cursor: pointer;
            border-radius: 200px;
            transition: 0.8s;
        }

        .dpbtn:hover {
            background: transparent;
            color: white;
            transform: scale(1.2);

        }

        .dpbtn:focus {
            outline: none;
            box-shadow: none;
        }

        .logob {
            border: none;
            /* background-image: url("{{ asset('images/cblue.png') }}");
                            background-repeat: no-repeat;
                            background-size: 100% 100%;
                            border-top: 2px solid #0000007a;
                            border-right: 2px solid #0000007a;
                            border-bottom: 0px solid #0000007a;
                            border-left: 0px solid #0000007a; */

            background: #061c2f85;
            border-top-right-radius: 22px;
            border-bottom-right-radius: 22px;

        }

        @media only screen and (max-width: 767px) {
            .photo-img {
                margin-top: 0% !important;
                width: 19rem;
                height: 19rem;
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                border-radius: 50%;

            }

            .profileform {
                margin-top: 0% !important;
            }

            .h1profile {
                font-size: 2.5rem;
                padding-top: 10% !important;
            }

            .logob {
                /* background-image: url("{{ asset('images/cblue.png') }}");
                                                                                                                                            background-repeat: no-repeat;
                                                                                                                                            background-size: 100% 100%; */
                border-top: 0px solid #134a68;
                border-left: 2px solid #134a68;
                border-right: 2px solid #134a68;
                border-bottom: 2px solid #134a68;
                background: #061c2f85 !important;
                border-bottom-left-radius: 22px !important;
                border-bottom-right-radius: 22px !important;
                border-top-right-radius: 0px !important;



            }

            .content-wrapper {
                background-image: url("{{ asset('images/profilebckmob.jpg') }}") !important;
                /* background-image: linear-gradient(0deg, #09103f -57%, #80d0c7 250%) !important; */
                /* background-image: linear-gradient(144deg, #205E9B -57%, #0575E6 250%) !important; */
                /* background-image: none !important; */
                background-repeat: no-repeat;
                background-size: 100% 100%;
                /* background-image: linear-gradient(92deg, #09103f 1%, #80d0c7 250%) !important; */

            }

            .border-right {
                /* border-right: 0px solid #dee2e6 !important; */
                border-top-left-radius: 22px;
                border-bottom-left-radius: 0px !important;
                border-top-right-radius: 22px !important;

            }

            .paddingprofile {
                padding-top: 4%;
                padding-bottom: 4%;
            }
        }

        .profileform {
            margin-top: 40%;
        }

        .photo-img {
            /* margin-top: 10%; */
            width: 19rem;
            height: 19rem;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            border-radius: 50%;
            transition: .9s
        }

        .photo-img:hover {
            text-transform: capitalize;
            transition: transform .9s, box-shadow 0.3s ease-in-out;
            transform: scale(1.1);
            box-shadow: 1px 1px 1px 1px;
        }

        .h1profile {
            font-size: 2.5rem;
            padding-top: 30%;
        }

        .content-wrapper {
            /* background-image: linear-gradient(0deg, #09103f -57%, #80d0c7 250%); */
            background-image: url("{{ asset('images/23628732.jpg') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            /* background-image: linear-gradient(92deg, #09103f 1%, #80d0c7 250%); */

        }

        .main-header {
            border-bottom: none;
        }

        .border-right {
            border-right: 0px solid #dee2e6 !important;
            border-top-left-radius: 22px;
            border-bottom-left-radius: 22px;
        }


        .mt-5,
        .my-5 {
            margin-top: 0rem !important;
        }

        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #13547a;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            /* margin: 11% auto; */
            margin: 12% 3%;

            box-shadow: inset 0px 0px 0px white;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none;
            }

            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }

        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #13547a;
            }
        }



        /* example */

        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content,
        #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 10%;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        .rotateimg90 {
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        .rotateimg180 {
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .rotateimg270 {
            -webkit-transform: rotate(270deg);
            -moz-transform: rotate(270deg);
            -ms-transform: rotate(270deg);
            -o-transform: rotate(270deg);
            transform: rotate(270deg);
        }

        .rotateimg360 {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }

        /* example */

    </style>
    <style>
        .paddingprofile {
            padding-top: 4%;

        }

        .text-field1 input {
            display: inline-block !important;
            /* border-bottom: solid medium #999 !important; */
            color: #ed0707bd !important;
            border: 1px solid #fa010140 !important;
            border-bottom: 2px solid #fa010140 !important;
            /* border-left: 1px solid #047ec0c9 !important; */
            background-color: rgba(255, 255, 255, 0) !important;
            padding: 10px 10px 10px 10px !important;
            border-top-left-radius: 14px !important;
            border-top-right-radius: 12px !important;
            border-bottom-left-radius: 2px !important;
            border-bottom-right-radius: 14px !important;
        }

    </style>



    <div class="paddingprofile">
        <div class="container">
            <div class="row">
                <div class="col-md-4 border-right bck ">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <div>
                            {{-- modal work --}}

                            {{-- <div id="myModal" class="modal">

                                <form class="" id="user_save_profile_form1" enctype="multipart/form-data">
                                    <meta name="csrf-token" content="{{ csrf_token() }}" />

                                    <span class="close">&times;</span>

                                    <img name="image" class="modal-content " id="img01" style="width:100%;max-width:300px"
                                        onclick="buttonclick();">
                                    <input name="angle" style="display: none" type="text" id="gimper" value="0">
                                    <div id="caption"></div>
                                </form>
                            </div> --}}

                            {{-- --------------------------- --}}

                            <form class="profileform" id="user_save_profile_form" enctype="multipart/form-data">
                                <meta name="csrf-token" content="{{ csrf_token() }}" />


                                @if (Auth::user()->dp == null)
                                    <div class="photo-img center mt-5 rounded-circle parent" id="image_user"
                                        style="background-image:url('{{ asset('images/userdp/default.png') }}'); margin-top:3%">
                                    </div>
                                @else
                                    @php
                                        $userdp = Auth::user()->dp;
                                    @endphp
                                    <div class="photo-img center rounded-circle parent" id="image_user"
                                        style="background-image:url('{{ asset('images/userdp') }}/{{ $userdp }}'); ">
                                        <svg class="checkmark child1" style="display: none" id="tick"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                                        </svg>
                                    </div>
                                    <img id="myImg" src="{{ asset('images/userdp') }}/{{ $userdp }}" alt=""
                                        style="display: none">
                                    <h1 class="h1profile">{{ Auth::user()->name }}</h1>
                                    <span class="badge badge-pill"
                                        style="font-size:15px;background-color: #000305a1;color: #3f647a">{{ auth()->user()->role->name }}</span>
                                @endif




                                {{-- <img class="rounded-circle center mt-5 " id="image_user" name='image_user'
                                        src="{{ asset('images/userdp/default.png') }}" > --}}

                                <input onchange="doAfterSelectImage(this)" type="file" style="display: none;"
                                    id="profile_pic" name="dp" />
                                <button type="button" for="imgupload" id="OpenImgUpload" class="dpbtn child"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-camera" viewBox="0 0 16 16">
                                        <path
                                            d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z" />
                                        <path
                                            d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                    </svg>
                                </button>
                                {{-- <span class="spanchild"> administator</span> --}}


                                {{-- <button id="submit" type="submit" class="btn btn-primary">Register</button> --}}
                            </form>
                            <script>
                                $('#OpenImgUpload').click(function() {
                                    $('#profile_pic').trigger('click');
                                });

                                $("#email").style({

                                    "position": "relative",
                                    "top": "-75px",
                                    'display': ,
                                    'inline-block',
                                    'color': '#ed0707bd',
                                    'border': '1px solid #fa010140',
                                    'border-bottom': '2px solid #fa010140',
                                    'background-color': 'rgba(255, 255, 255, 0)',


                                });

                            </script>


                        </div>
                    </div>
                </div>
                <div class="col-md-8 logob" style=" ">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-row align-items-center back"><i
                                    class="fa fa-long-arrow-left mr-1 mb-1"></i>
                                <a href="{{ route('home') }}"><i class="fa fa-caret-left"
                                        style="font-size:20px;color:white"></i></a>
                            </div>
                            <h6 class="text-right" style="color: white">Edit Your Profile</h6>
                        </div>
                        <form action="">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="text-field ">
                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                                            name="name" required>
                                        <label>Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-field">
                                        <input id="email" readonly type="text" class="form-control"
                                            value="{{ Auth::user()->email }}" required>
                                        <label class="labell ">Email</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="text-field">
                                        <input readonly type="text" class="form-control"
                                            value="{{ Auth::user()->phone }}" required>
                                        <label class="labell">Phone</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-field">
                                        <input readonly type="text" class="form-control"
                                            value="{{ Auth::user()->mobile }}" required>
                                        <label class="labell">Mobile</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">

                                <div class="col-md-12">
                                    <div class="text-field">
                                        <textarea type="text" class="form-control" name="address"
                                            placeholder="Enter Address" rows="3"
                                            required>{{ Auth::user()->address }}</textarea>
                                        <label class="labell">Address</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="text-field">
                                        <input readonly type="text" class="form-control"
                                            value="{{ Auth::user()->role->name }}">
                                        <label class="labell">Post</label>
                                        {{-- value="{{ Auth::user()->role->name }}" --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-field">
                                        <input readonly type="text" class="form-control" required>
                                        <label class="labell">Post</label>
                                        {{-- value="{{ Auth::user()->role->name }}" --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="text-field">
                                        <input readonly type="text" class="form-control" required>
                                        <label class="labell">Phone</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-field">
                                        <input readonly type="text" class="form-control" required>
                                        <label class="labell">Phone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="submit">Save
                                    Profile</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>


    </script>



    {{-- example --}}
    {{-- <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("image_user");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        var wow = document.getElementById("gimper");
        var hiddenimg = document.getElementById("myImg");
        var angle = 40;
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = hiddenimg.src;
            captionText.innerHTML = 'Click to Rotate';
        }




        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            updateRotatedImage(modalImg.src, wow.value);
        }

        function buttonclick() {

            document.getElementById("gimper").value++;
            var wow = document.getElementById("gimper").value;
            if (wow < 5) {
                hello(wow);
            }

        }

        function hello(eoe) {

            if (eoe == 1) {
                var angle = 90;
                modalImg.className = "modal-content rotateimg" + angle;

            }
            if (eoe == 2) {
                var angle = 180;
                modalImg.className = "modal-content rotateimg" + angle;
            }
            if (eoe == 3) {
                var angle = 270;
                modalImg.className = "modal-content rotateimg" + angle;
            }
            if (eoe == 4) {
                var angle = 360;
                modalImg.className = "modal-content rotateimg" + angle;
                document.getElementById("gimper").value = 0;
            }
        }

        function updateRotatedImage(Img, Wow) {

            var Image = Img;
            var angle = (Wow * 90);
            console.log(Image);
            console.log(angle);


            // let myForm = document.getElementById('user_save_profile_form');
            var form_data = new FormData($('#user_save_profile_form1')[0]);

            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "imagerotate",
                dataType: 'JSON',

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    image: Image,
                    angle: angle,
                },



                success: function(responese) {
                    $('#tick').show();
                    setTimeout(function() {
                        $('#tick').hide();
                    }, 3000);
                    // setTimeout(function(){ $("#tick").css("display", "block"); },2000);
                },
            });
        }

    </script> --}}

    {{-- example --}}

    <script>
        function doAfterSelectImage(input) {
            // console.log(input)
            var image = document.getElementById('profile_pic').files[0];
            var image_name = image.name;
            var image_extention = image_name.split('.').pop().toLowerCase();
            // console.log("metod");

            if (jQuery.inArray(image_extention, ['png', 'jpg', 'jpeg']) == -
                1) {
                alert('Invalid file type');
            } else {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_user').css('background-image', 'url(' + e.target.result + ')');
                        $('#dpuser').prop('src', e.target.result);

                        // $("#image_user").attr("src", '{{ asset('images/userdp/pic') }}' );
                    };
                    reader.readAsDataURL(input.files[0]);
                    uploadUserProfileImage();
                }
            }
            // readURL(input);
        }

        // function readURL(input) {
        //     var image = document.getElementById('profile_pic').files[0];
        //     var image_name = image.name;
        //     var image_extention = image_name.split('.').pop().toLowerCase();
        //     console.log("metod");

        //     if (jQuery.inArray(image_extention, ['png', 'jpg', 'jpeg']) == -
        //         1) {
        //         alert('Invalid file type');
        //     } else {

        //         if (input.files && input.files[0]) {
        //             var reader = new FileReader();
        //             reader.onload = function(e) {
        //                 $('#image_user').css('background-image', 'url(' + e.target.result + ')');
        //                 $('#dpuser').prop('src', e.target.result);

        //                 // $("#image_user").attr("src", '{{ asset('images/userdp/pic') }}' );
        //             };
        //             reader.readAsDataURL(input.files[0]);
        //             uploadUserProfileImage();
        //         }
        //     }
        // }

        function uploadUserProfileImage() {
            // let myForm = document.getElementById('user_save_profile_form');
            var form_data = new FormData($('#user_save_profile_form')[0]);

            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "saveimage",
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                success: function(responese) {
                    $('#tick').show();
                    setTimeout(function() {
                        $('#tick').hide();
                    }, 3000);
                    // setTimeout(function(){ $("#tick").css("display", "block"); },2000);
                },
            });
        }

    </script>


@endsection
