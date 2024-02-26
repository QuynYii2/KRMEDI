<link href="{{ asset('css/tabcreatereviewstore.css') }}" rel="stylesheet">
<div class="recruitment-details ">
    <div class="container-fluid">
        <div class="recruitment-details--title"><a href="{{route('home.specialist.detail',$id)}}"><i
                    class="fa-solid fa-arrow-left"></i> {{ __('home.Review') }}</a></div>
        <form action="{{route('home.specialist.review',$id)}}" method="post">
            <div class="row recruitment-details--content">
                @csrf
                @method('POST')
                <div class="font-weight-600 fs-24px text-center row">
                    <span>{{ __('home.Are you satisfied with') }}
                        <strong>
                            @php
                                $shop = \App\Models\Clinic::where('id', $id)->first();
                            @endphp
                            {{$shop->name}}
                        </strong>
                        {{ __('home.Services') }}?
                    </span>
                </div>
                <div class="mt-md-4 mb-md-5 d-flex justify-content-center">
                    <input type="radio" name="star_number" id="star-edit-1" value="1" hidden="" required>
                    <label for="star-edit-1" onclick="starCheckEdit(1)"><i id="icon-star-edit-1"
                                                                           class="fa fa-star fa-2xl p-1"></i></label>
                    <input type="radio" name="star_number" id="star-edit-2" value="2" hidden="">
                    <label for="star-edit-2" onclick="starCheckEdit(2)"><i id="icon-star-edit-2"
                                                                           class="fa fa-star fa-2xl p-1"></i></label>
                    <input type="radio" name="star_number" id="star-edit-3" value="3" hidden="">
                    <label for="star-edit-3" onclick="starCheckEdit(3)"><i id="icon-star-edit-3"
                                                                           class="fa fa-star fa-2xl p-1"></i></label>
                    <input type="radio" name="star_number" id="star-edit-4" value="4" hidden="">
                    <label for="star-edit-4" onclick="starCheckEdit(4)"><i id="icon-star-edit-4"
                                                                           class="fa fa-star fa-2xl p-1"></i></label>
                    <input type="radio" name="star_number" id="star-edit-5" value="5" hidden="" checked>
                    <label for="star-edit-5" onclick="starCheckEdit(5)"><i id="icon-star-edit-5"
                                                                           class="fa fa-star fa-2xl p-1"></i></label>
                </div>
                <div>
                    <label for="cmt-review">{{ __('home.Add detailed review') }}</label>
                    <div>
                        <textarea id="cmt-review" name="cmt_review" class="cmt_review" placeholder="{{ __('home.Your comment') }}"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="recruitment-details--btn col-md-6 justify-content-end d-flex">
                    <a href="{{route('home.specialist.detail',$id)}}" class="btn btn-primary button-Reset-booking col-md-6">{{ __('home.CANCEL') }}</a>
                </div>
                <div class="recruitment-details--btn col-md-6 justify-content-start d-flex">
                    <button class="btn btn-primary col-md-6 button-apply-booking" type="submit">{{ __('home.Submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    async function getCommentById(id) {
        let url = urla;
        url = url.replace(':id', id);

        const response = await fetch(url);

        if (response.ok) {
            const data = await response.json();
            starCheckEdit(data[0].star_number)
        }
    }

    function starCheckEdit(value) {
        console.log(value)
        let input = document.getElementById('input-star-edit');
        let star = document.getElementById('star-edit-' + value);
        let icon = document.getElementById('icon-star-edit-' + value);

        let isChecked = star.checked;

        // Toggle the clicked star
        star.checked = !isChecked;

        for (let i = 1; i <= 5; i++) {
            let currentStar = document.getElementById('star-edit-' + i);
            let currentIcon = document.getElementById('icon-star-edit-' + i);

            if (i <= value) {
                currentStar.checked = true;
                currentIcon.classList.add("checked");
            } else {
                currentStar.checked = false;
                currentIcon.classList.remove("checked");
            }
        }

        input.value = star.checked ? value : value - 1;
    }

    async function handleDeleteEvaluate(id) {

        let isDelete = confirm('Banj cos muon xoa k');
        if (isDelete) {
            let url = urlb;
            url = url.replace(':id', id);
            const respone = await fetch(url);

            if (respone.ok) {
                location.reload();
            }
        }
    }

</script>
