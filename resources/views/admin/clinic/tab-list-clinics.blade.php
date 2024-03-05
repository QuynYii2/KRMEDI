<link href="{{ asset('css/tablistclinics.css') }}" rel="stylesheet">
<div class="">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('home.Thumbnail') }}</th>
            <th scope="col">{{ __('home.Name') }}</th>
            <th scope="col">{{ __('home.Addresses') }}</th>
            <th scope="col">{{ __('home.open_date') }}</th>
            <th scope="col">{{ __('home.close_date') }}</th>
            <th scope="col">{{ __('home.Status') }}</th>
            <th scope="col">{{ __('home.Edit') }}</th>
        </tr>
        </thead>
        <tbody id="ClinicsAdmin">
        </tbody>
    </table>
</div>
<script>

    $(document).ready(() => {

        callListProduct(token, 'CLINICS');

        $('#type_medical').on('change', function () {
            let type = $(this).val();
            callListProduct(token, type);
        });

        async function callListProduct(token, type) {
            const accessToken = `Bearer ${token}`;

            let url;
            console.log(type)
            switch (type) {
                case "PHARMACIES":
                    url = `{{ route('api.backend.pharmacies.lists') }}`;
                    console.log(url)
                    break;
                case "HOSPITALS":
                    url = `{{ route('api.backend.hospitals.lists') }}`;
                    console.log(url)
                    break;
                default:
                    url = `{{ route('api.backend.clinics.lists') }}`;
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
                await renderClinics(response);
            } catch (exception) {
                console.log(exception);
            }
        }
    });


    async function renderClinics(res) {
        let html = ``;

        for (let i = 0; i < res.length; i++) {
            let urlEdit = `{{route('clinics.edit', ['id' => ':id'])}}`;
            urlEdit = urlEdit.replace(':id', res[i].id);
            let item = res[i];
            let rowNumber = i + 1;

            let gallery = item.gallery;
            let arrayGallery = [];

            if (gallery) {
                arrayGallery = gallery.split(',');
            }

            let img = ``;

            img = `<img loading="lazy" class="mr-2 w-auto h-100" src="${arrayGallery[0]}" alt="">`;


            html = html + `<tr>
            <th scope="row">${rowNumber}</th>
            <td>${img}</td>
            <td>${item.name}</td>
            <td>${item.address_detail}</td>
            <td>${item.open_date}</td>
            <td>${item.close_date}</td>
            <td>${item.status}</td>
            <td><a href="${urlEdit}"> {{ __('home.Edit') }}</a> | <a href="#" onclick="checkDelete(${item.id})">{{ __('home.Delete') }}</a></td>
        </tr>`;
        }
        await $('#ClinicsAdmin').empty().append(html);
    }

    async function deleteClinics(token, id) {
        let accessToken = `Bearer ` + token;
        let urlDelete = `{{route('api.backend.clinics.delete', ['id' => ':id'])}}`;
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
            deleteClinics(token, value)
        }
    }

</script>
