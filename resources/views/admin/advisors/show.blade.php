@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.advisor.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.advisors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.advisor.fields.id') }}
                        </th>
                        <td>
                            {{ $advisor->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advisor.fields.name') }}
                        </th>
                        <td>
                            {{ $advisor->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advisor.fields.description') }}
                        </th>
                        <td>
                            {!! $advisor->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advisor.fields.availability') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $advisor->availability ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advisor.fields.price') }}
                        </th>
                        <td>
                            {{ $advisor->price->toFloat() }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advisor.fields.profile') }}
                        </th>
                        <td>
                            @if($advisor->profile)
                                <a href="{{ $advisor->profile->getUrl() }}" target="_blank" style="display: inline-block">
                                    @if (config('app.env') !== 'local' && config('app.env') !== 'testing')
                                        <img src="{{ $advisor->profile->getUrl('preview') }}">
                                        @else
                                        <img width="100px" src="{{ $advisor->profile->getUrl() }}">
                                    @endif
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.advisor.fields.language') }}
                        </th>
                        <td>
                            @foreach($advisor->languages as $key => $language)
                                <span class="label label-info">{{ $language->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.advisors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
