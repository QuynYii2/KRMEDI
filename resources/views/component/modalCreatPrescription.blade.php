<div class="modal modal-cart modalCreatPrescription fade" id="modalCreatPrescription" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('home.Create prescription') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="add-img col-md-9">
                        <div class="title">
                            <p>{{ __('home.Please upload your prescription file') }}</p>
                        </div>
                        <label id="prescriptionLabel" for="prescription">
                            <div class="upload-item-input d-flex justify-content-between">
                                <div class="upload-icon">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                        </label>
                        <input type="file" class="form-control" id="prescription"
                               accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                               style="visibility:hidden;">
                    </div>
                    <div class="form-group col-md-3">
                        <button type="button" class="btnGetFile btn btn-outline-warning mt-4">
                            {{ __('home.Xem đơn mẫu') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn cancel" data-dismiss="modal">{{ __('home.CANCEL') }}</button>
                <button type="button" data-dismiss="modal" id="btnUploadPrescription"
                        class="btn pay">{{ __('home.create') }}</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btnUploadPrescription').click(function () {
        confirmCreatePrescription();
    });

    function confirmCreatePrescription() {
        if (confirm('You definitely want to create a prescription?')) {
            createPrescription();
        }
    }

    async function createPrescription() {
        const formData = new FormData();
        let prescriptions = $('#prescription')[0].files[0];
        if (!prescriptions) {
            alert('Please upload file prescription!');
            return;
        }
        formData.append('prescriptions', prescriptions);

        try {
            await $.ajax({
                url: `{{ route('restapi.products.medicines.prescriptions.blade') }}`,
                method: 'POST',
                contentType: false,
                cache: false,
                data: formData,
                processData: false,
                success: function (response, textStatus, jqXHR) {
                    if (jqXHR.status == 200) {
                        window.location.reload();
                    }
                    alert(response.message);
                },
                error: function (error) {
                    console.log(error);
                    alert(error.responseJSON.message);
                }
            });
        } catch (e) {
            console.log(e)
            alert('Error, please try again!')
        }
    }

    $('.btnGetFile').on('click', function () {
        let alertMessage = `Vui lòng nhập vào file theo định dạng mẫu đã được viết sẵn! Chúng tôi không khuyến khích bất kì hành động thay đổi định dạng file hoặc cấu trúc dữ liệu trong file vì điều này sẽ ảnh hướng đến việc đọc hiểu dữ liệu.`
        if (confirm(alertMessage)){
            window.location.href = `{{ route('user.download') }}`;
        }
    })
</script>
<script>
    $("#prescription").change(function () {
        var filename = this.files[0].name;
        $('#prescriptionLabel').text(filename);
    });
</script>
