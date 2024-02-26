<link href="{{ asset('css/tablistdoctor.css') }}" rel="stylesheet">
<div class="">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('home.Thumbnail') }}</th>
            <th scope="col">{{ __('home.Chuyên Môn') }}</th>
            <th scope="col">{{ __('home.Năm kinh nghiệm') }}</th>
            <th scope="col">{{ __('home.Dịch vụ cung cấp') }}</th>
            <th scope="col">{{ __('home.Thời gian') }}</th>
            <th scope="col">{{ __('home.Những ngày làm việc') }}</th>
        </tr>
        </thead>
        <tbody id="ProductsAdmin">

        </tbody>
    </table>
</div>
<script>

    $(document).ready(() => {
        callListProduct(token, 'DOCTOR');

        $('#type_medical').on('change', function () {
            let type = $(this).val();
            callListProduct(token, type);
        });

        async function callListProduct(token, type) {
            const accessToken = `Bearer ${token}`;

            let url;
            console.log(type)
            switch (type) {
                case "NURSES":
                    url = `{{ route('api.backend.phamacitis.list') }}`;
                    console.log(url)
                    break;
                case "PHAMACISTS":
                    url = `{{ route('api.backend.phamacitis.list') }}`;
                    console.log(url)
                    break;
                case "THERAPISTS":
                    url = `{{ route('api.backend.doctors.info.list') }}`;
                    console.log(url)
                    break;
                case "ESTHETICIANS":
                    url = `{{ route('api.backend.doctors.info.list') }}`;
                    console.log(url)
                    break;
                default:
                    url = `{{ route('api.backend.doctors.info.list.by.user') }}`;
                    console.log(url)
                    break;

            }

            $('#listTextMedical').text('List ' + type);
            try {
                const response = await $.ajax({
                    url: url,
                    method: 'GET',
                    headers: {
                        Authorization: accessToken,
                    },
                });
                await renderProduct(response);
            } catch (exception) {
                console.log(exception);
            }
        }
    });


    async function renderProduct(res) {
        console.log(res)
        let html = ``;

        for (let i = 0; i < res.length; i++) {
            let urlEdit = `{{route('doctor.edit', ['id' => ':id'])}}`;
            urlEdit = urlEdit.replace(':id', res[i].id);
            let item = res[i];
            let rowNumber = i + 1;

            let thumbnail = item.avt;
            let arrayGallery = thumbnail.split(',')
            let img = ``;
            for (let j = 0; j < arrayGallery.length; j++) {
                img = img + `<img loading="lazy" class="mr-2 w-auto h-100" src="${arrayGallery[j]}" alt="">`;
            }
            html = html + `<tr>
            <th scope="row">${i + 1}</th>
            <td>${img}</td>
            <td>${item.specialty}</td>
            <td>${item.year_of_experience}</td>
            <td>${item.service} </td>
            <td>${item.time_working_1}</td>
            <td>${item.time_working_2}</td>
            <td><a href="${urlEdit}"> {{ __('home.Edit') }}</a> | <a href="#" onclick="checkDelete(${item.id})">{{ __('home.Delete') }}</a></td>
        </tr>`;
        }
        await $('#ProductsAdmin').empty().append(html);
    }

    async function deleteCoupon(token, id) {
        let accessToken = `Bearer ` + token;
        let urlDelete = `{{route('api.backend.doctors.info.delete', ['id' => ':id'])}}`;
        urlDelete = urlDelete.replace(':id', id);
        await $.ajax({
            url: urlDelete,
            method: 'DELETE',
            headers: {
                "Authorization": accessToken,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert('Delete Success!');
                window.location.reload();
            },
            error: function (exception) {
                console.log(exception)
            }
        });
    }

    function checkDelete(value) {
        if (confirm('Are you sure you want to delete?') == true) {
            deleteCoupon(token, value)
        }
    }

</script>
