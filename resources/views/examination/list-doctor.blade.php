<div id="list-doctor" class="list-doctor d-flex  container">

</div>
<script>
    $(document).ready(function () {
        async function callListDoctor() {
            await $.ajax({
                url: `{{route('doctors.info.restapi.list')}}`,
                method: 'GET',
                success: function (response) {
                    showListDoctor(response);
                },
                error: function (exception) {
                    console.log(exception)
                }
            });
        }

        callListDoctor();

        function showListDoctor(res) {
            let html = ``;
            let url = `{{ asset('storage') }}`;
            let detailDoctor = `{{ route('examination.doctor_info', ['id' => ':id']) }}`;
            for (let i = 0; i < res.length; i++) {
                let item = res[i];
                let mainUrl = detailDoctor.replace(':id', item['id']);
                let imageDoctor = item['thumbnail'];
                let myArray = imageDoctor.split("/storage");
                html = html + `<div class="card" >
                <div class="ribbon ribbon-top-left"><span>New</span></div>
                <i class="bi bi-heart"></i>
                <img src=" ${url}${myArray[1]} " class="card-img-top" alt="...">
                <div class="card-body">
                    <a href="${mainUrl}"><h5 class="card-title">${item['name']}</h5></a>
                    <p class="card-text">Specialty: ${item['specialty']}</p>
                    <p class="card-text_1">Location: <b>${item['detail_address']}</b></p>
                    <p class="card-text_1">Working time: <b>${item['time_working_1']}</b></p>
                </div>
            </div>`;

            }
            $('#list-doctor').empty().append(html);
        }
    })
</script>
