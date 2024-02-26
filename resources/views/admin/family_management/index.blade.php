@php use App\Enums\RelationshipFamily; @endphp
@extends('layouts.admin')

@section('main-content')

    @if($family_members->isEmpty())
        <a href="{{ route('api.backend.family-management.create') }}"
           class="btn btn-primary mb-3">{{ __('home.Tao moi gia dinh') }}</a>
    @else
        <a href="{{ route('api.backend.family-management.addMember') }}"
           class="btn btn-primary mb-3">{{ __('home.Them thanh vien moi') }}</a>
    @endif

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">{{ __('home.STT') }}</th>
            <th scope="col">{{ __('home.ma gia dinh') }}</th>
            <th scope="col">{{ __('home.ten thanh vien') }}</th>
            <th scope="col">{{ __('home.quan he voi chu ho') }}</th>
            <th scope="col">{{ __('home.Action') }}</th>
        </tr>
        </thead>
        <tbody>

        @if($family_members->isNotEmpty())
            @foreach($family_members as $index => $member)
                <tr>
                    <th scope="row">{{ ++$index }}</th>
                    <td>{{ $member->family_code }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ RelationshipFamily::getLabels()[$member->relationship] ?? $member->relationship }}</td>
                    <td class="d-flex">
                        <form style="margin-right: 10px"
                              action="{{route('api.backend.family-management.edit',$member->id)}}" method="get">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </form>

                        <form action="{{route('api.backend.family-management.destroy',$member->id)}}" method="post">
                            @csrf
                            <button type="submit" class="ml-3 btn btn-primary btn-danger">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">{{ __('home.no data') }}</td>
            </tr>
        @endif


        </tbody>
    </table>

@endsection
