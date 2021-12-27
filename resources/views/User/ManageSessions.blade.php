@extends('Layouts.app')

@section('Content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">تنظیمات</h1>
                    </div>
                    <form class="user" id="SessionSettingForm" action="{{ route('user.SubmitSessionSetting') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>مدت زمان پایان نشست کاربر : </label>
                            </div>
                            <div class="col-sm-2">
                                @if ($sets->count() > 0)
                                <input type="text" class="form-control form-control-user" id="SessionTimeout" name="SessionTimeout"
                                placeholder="" value="{{ $sets->where('SettingKey','=','SessionTimeout')->firstOrFail()->SettingValue ?? config('session.lifetime') }}">
                                @else
                                <input type="text" class="form-control form-control-user" id="SessionTimeout" name="SessionTimeout"
                                placeholder="" value="{{ config('session.lifetime') }}">
                                @endforelse
                            </div>
                        </div>
                        <button type="submit"  id="btnSubmit" class="btn btn-primary btn-user btn-block" style="width:25%;margin:auto;margin-top: 3rem;">
                            ذخیره اطلاعات
                        </button>
                        <hr />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
