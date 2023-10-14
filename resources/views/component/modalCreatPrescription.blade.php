<div class="modal modal-cart modalCreatPrescription fade" id="modalCreatPrescription" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create prescription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-9">
                        <div class="title">
                            Medicine name
                        </div>
                        <input type="text" placeholder="example123">
                    </div>
                    <div class="col-3 d-flex align-items-end">
                        <select name="pets" id="pet-select">
                            <option value="">Box</option>
                            <option value="">Blister</option>
                            <option value="">Pellets</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="title">
                            School <i style="color: rgba(255, 0, 0, 1)" class="fa-solid fa-asterisk"></i>
                        </div>
                        <input type="text">
                    </div>
                    <div class="col-6">
                        <div class="title">
                            Degree <i style="color: rgba(255, 0, 0, 1)" class="fa-solid fa-asterisk"></i>
                        </div>
                        <select name="pets" id="pet-select">
                            <option value="">Please choose....</option>
                            <option value="">Please choose....</option>
                            <option value="">Please choose....</option>
                            <option value="">Please choose....</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="title">
                            From month <i style="color: rgba(255, 0, 0, 1)" class="fa-solid fa-asterisk"></i>
                        </div>
                        <input class="ac-birth" type="date">
                    </div>
                    <div class="col-6">
                        <div class="title">
                            To month <i style="color: rgba(255, 0, 0, 1)" class="fa-solid fa-asterisk"></i>
                        </div>
                        <input class="ac-birth" type="date">
                    </div>
                </div>
                <div class="add-img">
                    <div class="title">
                        Achievement
                        <p>Please upload a photo of your prescription (maximum 5 photos)</p>
                    </div>
                    <button type="button">
                        <i class="fa-solid fa-plus"></i>

{{--                        Tải ảnh lên bỏ thẻ i thay img --}}
{{--                        <img src="{{asset('img/Rectangle 23810.png')}}" alt="">--}}
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn pay">Pay</button>
            </div>
        </div>
    </div>
</div>
