<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ __('home.Multiple Image Upload') }}</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<link href="{{ asset('css/uploadgallery.css') }}" rel="stylesheet">

<body>
<div class="row">
    <div class="mb-3">
        <div id="galleryList" class="d-flex flex-wrap">
            <!--display the images uploaded-->
            <div id="galleryControls">
                <input class="form-control" id="galleryPics" type="file" accept="image/jpeg, image/png, image/jpg"
                       multiple hidden>
                <input id="checkImageQty" hidden>
                <button type="button" id="galleryUploadBtn" onclick="galleryUploadBtnActive()"><i
                        class="fas fa-plus"></i></button>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<script>
    const galleryDt = new DataTransfer();
    const max_gallery = 10;

    const galleryUploadInput = document.getElementById("galleryPics");
    const checkImageQty = document.getElementById("checkImageQty");
    const galleryList = document.getElementById("galleryList");
    const galleryCtrls = document.getElementById("galleryControls");

    function galleryUploadBtnActive() {
        galleryUploadInput.click();
    }

    function renderImage() {
        if ((galleryDt.items.length + this.files.length) <= max_gallery) {
            //preview the images
            for (let i = 0; i < this.files.length; i++) {
                let file = this.files[i];
                if (file) {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.addEventListener("load", function () {
                        let result = reader.result;
                        let imageCon = document.createElement("div");
                        imageCon.classList.add("gallery-preview-wrapper");
                        imageCon.classList.add("d-flex");
                        imageCon.classList.add("align-items-center");
                        imageCon.classList.add("justify-content-center");
                        imageCon.classList.add("d-inline-block");
                        imageCon.classList.add("active");
                        imageCon.innerHTML =
                            '<div class="gallery-pic-container d-flex align-items-center justify-content-center overflow-hidden">' +
                            `<input type="checkbox" onchange="checkInput();" value="${i}" name="inputCheck[]" class="image-checkbox position-absolute top-0 start-0">` + // Checkbox added here
                            '<img></div><div class="gallery-cancel-btn"><i class="fas fa-times"></i></div><div class="gallery-file-name"></div>';
                        imageCon.firstElementChild.lastElementChild.src = result; // Set image src
                        imageCon.children[2].innerHTML = file.name; // Set file name
                        /*addEventListener to cancel button*/
                        imageCon.children[1].addEventListener("click", function () {
                            const fileName = this.parentElement.children[2].innerHTML;
                            this.parentElement.remove();
                            for (let i = 0; i < galleryDt.items.length; i++) {
                                if (fileName === galleryDt.items[i].getAsFile().name) {
                                    galleryDt.items.remove(i);
                                    let listInput = document.getElementsByClassName('image-checkbox');
                                    for (let j = 0; j < listInput.length; j++) {
                                        let checkbox = listInput[j];
                                        let currentValue = parseInt(checkbox.value);
                                        if (currentValue > i) {
                                            checkbox.value = (currentValue - 1).toString();
                                        }
                                    }
                                    continue;
                                }
                            }
                            // Updating input file files after deletion
                            galleryUploadInput.files = galleryDt.files;
                            if (galleryUploadInput.files.length < max_gallery && galleryCtrls.hasAttribute("hidden")) {
                                galleryCtrls.removeAttribute("hidden");
                            }
                            checkInput();
                        });

                        galleryList.insertBefore(imageCon, galleryCtrls);
                    });
                    reader.onerror = function () {
                        alert(reader.error);
                    };
                }
            }
            for (let file of this.files) {
                galleryDt.items.add(file);
            }
            this.files = galleryDt.files;
            if (this.files.length == max_gallery) {
                galleryCtrls.setAttribute("hidden", "");
            }
        } else {
            galleryUploadInput.files = galleryDt.files;
            alert("Please upload 5 images only!");
        }
    }

    galleryUploadInput.addEventListener("change", renderImage);

    function checkInput() {
        let arrayItem = [];
        let listInput = document.getElementsByClassName('image-checkbox');
        for (let i = 0; i < listInput.length; i++) {
            let item = listInput[i];
            if (item.checked) {
                if (!arrayItem.includes(item.value)) {
                    arrayItem.push(item.value);
                }
            } else {
                let index = arrayItem.indexOf(item.value);
                if (index !== -1) {
                    arrayItem.splice(index, 1);
                }
            }
        }
        arrayItem.sort();
        let data = arrayItem.toString();
        // console.log(data);
        checkImageQty.value = data;
    }
</script>
