<link rel="stylesheet" href="{{asset('css/clinics-style.css')}}">
<style>
    .border-specialList {
        border-radius: 16px;
        border: 1px solid #EAEAEA;
        background: #FFF;
        display: flex;
        padding: 16px;
        align-items: flex-start;
        gap: 16px;
    }

    .title-specialList-clinics {
        color: #000;
        font-size: 24px;
        font-style: normal;
        font-weight: 800;
        display: -webkit-box;
        line-height: 1.3;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .address-clinics {
        color: #929292;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .address-clinics div {
        display: -webkit-box;
        line-height: 1.3;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .distance {
        color: #088180;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .time-working {
        font-size: 12px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .color-timeWorking {
        color: #088180;

    }
</style>
<div class="body m-0 d-flex flex-wrap w-100" id="listClinic">

</div>
<script>
    $(document).ready(function () {
        callListProduct();

        async function callListProduct() {
            await $.ajax({
                url: `{{route('clinics.restapi.list')}}`,
                method: 'GET',
                success: function (response) {
                    renderClinics(response);
                },
                error: function (exception) {
                    console.log(exception)
                }
            });
        }

        async function renderClinics(res) {
            let html = ``;
            const baseUrl = '{{ route("clinic.detail", ["id" => ":id"]) }}';
            for (let i = 0; i < res.length; i++) {
                let item = res[i];
                let urlDetail = baseUrl.replace(':id', item.id);
                let gallery = item.gallery;
                let arrayGallery = gallery.split(',')
                let img = ``;
                img += `<img class="mr-2 img-item1" src="${arrayGallery[0]}" alt="">`;
                // for (let j = 0; j < arrayGallery.length; j++) {
                //     img = img + `<img class="mr-2 w-auto h-100 img-item1 " src="${arrayGallery[j]}" alt="">`;
                // }
                let serviceHtml = ``;
                let service = item.services;
                for (let j = 0; j < service.length; j++) {
                    let serviceItem = service[j];
                    serviceHtml = serviceHtml + `<span>${serviceItem.name},</span>`;
                }
                let openDate = new Date(item.open_date);
                let closeDate = new Date(item.close_date);

                let formattedOpenDate = `${openDate.getHours()}:${openDate.getMinutes()}`;
                let formattedCloseDate = `${closeDate.getHours()}:${closeDate.getMinutes()}`;

                html = html + `
                <div class="specialList-clinics col-md-6 mt-3">
                        <a href="${urlDetail}">
                            <div class="border-specialList">
                                 <div class="content__item d-flex gap-3">
                                      <div class="specialList-clinics--img">
                                           ${img}
                                      </div>
                                      <div class="specialList-clinics--main w-100">
                                           <div class="title-specialList-clinics">
                                        @if(locationHelper() == 'vi')
                                                        ${item.name}
                                                            @else
                                                        ${item.name_en}

                                                            @endif
                                           </div>
                                      <div class="address-specialList-clinics">
                                 <div class="d-flex align-items-center address-clinics">
                                      <i class="fas fa-map-marker-alt mr-2"></i>
                                      <div>${item.address_detail} ${item.addressInfo}</div>
                                 </div>
                                    <span class="distance"> - >=10Km</span>
                            </div>
                            <div class="time-working">
                                 <span class="color-timeWorking">
                                    <span class="fs-14 font-weight-600">${formattedOpenDate} - ${formattedCloseDate}</span>
                                    <span>/ {{ __('home.Dental Clinic') }}</span>
                                    </span>

                            </div>
                            </div>
                            </div>
                            </div>
                        </a>
                    </div>
                `;
            }
            await $('#listClinic').empty().append(html);
        }
    });
</script>


