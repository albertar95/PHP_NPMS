@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">تنظیمات امنیتی کلمه عبور کاربران</h1>
                        </div>
                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                            <form class="user" id="PasswordPolicyForm" style="text-align: right;"
                                action="{{ route('user.SubmitPasswordPolicy') }}" method="POST">
                                @csrf
                                @if ($Policies->where('SettingKey', '=', 'PasswordDificulty')->count() > 0)
                                    <input id="PasswordDificulty" name="PasswordDificulty"
                                        value="{{ $Policies->where('SettingKey', '=', 'PasswordDificulty')->firstOrFail()->SettingValue ?? '' }}"
                                        type="text" hidden>
                                @else
                                    <input id="PasswordDificulty" name="PasswordDificulty" value="1" type="text" hidden>
                                @endforelse
                                @if ($Policies->where('SettingKey', '=', 'FullLockoutUser')->count() > 0)
                                    <input id="FullLockoutUser" name="FullLockoutUser"
                                        value="{{ $Policies->where('SettingKey', '=', 'FullLockoutUser')->firstOrFail()->SettingValue ?? '' }}"
                                        type="text" hidden>
                                @else
                                    <input id="FullLockoutUser" name="FullLockoutUser" value="0" type="text" hidden>
                                @endforelse
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label>حداقل طول کلمه عبور : </label>
                                    </div>
                                    <div class="col-sm-3">
                                        @if ($Policies->where('SettingKey', '=', 'PasswordLength')->count() > 0)
                                            <input type="text" style="margin-bottom: 10px;"
                                                class="form-control form-control-user" id="PasswordLength"
                                                name="PasswordLength" placeholder=""
                                                value="{{ $Policies->where('SettingKey', '=', 'PasswordLength')->firstOrFail()->SettingValue ?? '' }}">
                                        @else
                                            <input type="text" style="margin-bottom: 10px;"
                                                class="form-control form-control-user" id="PasswordLength"
                                                name="PasswordLength" placeholder="" value="4">
                                        @endforelse
                                    </div>
                                    <div class="col-sm-3">
                                        <label>دوره تغییر کلمه عبور : </label>
                                    </div>
                                    <div class="col-sm-3">
                                        @if ($Policies->where('SettingKey', '=', 'ChangePasswordDuration')->count() > 0)
                                            <input type="text" style="margin-bottom: 10px;"
                                                class="form-control form-control-user" id="ChangePasswordDuration"
                                                name="ChangePasswordDuration" placeholder="روز"
                                                value="{{ $Policies->where('SettingKey', '=', 'ChangePasswordDuration')->firstOrFail()->SettingValue ?? '' }}">
                                        @else
                                            <input type="text" style="margin-bottom: 10px;"
                                                class="form-control form-control-user" id="ChangePasswordDuration"
                                                name="ChangePasswordDuration" placeholder="روز" value="45">
                                        @endforelse
                                    </div>
                                    <div class="col-sm-3">
                                        <label>تعداد کلمات عبور قبلی : </label>
                                    </div>
                                    <div class="col-sm-3">
                                        @if ($Policies->where('SettingKey', '=', 'LastPasswordCount')->count() > 0)
                                            <input type="text" style="margin-bottom: 10px;"
                                                class="form-control form-control-user" id="LastPasswordCount"
                                                name="LastPasswordCount" placeholder=""
                                                value="{{ $Policies->where('SettingKey', '=', 'LastPasswordCount')->firstOrFail()->SettingValue ?? '' }}">
                                        @else
                                            <input type="text" style="margin-bottom: 10px;"
                                                class="form-control form-control-user" id="LastPasswordCount"
                                                name="LastPasswordCount" placeholder="" value="3">
                                        @endforelse
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-top: 3rem;">
                                    <div class="col-sm-3">
                                        <label>پیچیدگی کلمه عبور : </label>
                                    </div>
                                    @if ($Policies->where('SettingKey', '=', 'PasswordDificulty')->count() > 0)
                                        @if ($Policies->where('SettingKey', '=', 'PasswordDificulty')->firstOrFail()->SettingValue == 1)
                                            <div class="col-sm-3" style="display: flex;">
                                                <div class="col-sm-1">
                                                    <input type="radio" style="width:1rem;margin:unset !important;" checked
                                                        value="1" name="DificultyChoose" id="NoDifficulty"
                                                        class="form-control" alt="" />
                                                </div>
                                                <label for="NoDifficulty" style="margin:.45rem .45rem 0 0">بدون
                                                    پیچیدگی</label>
                                            </div>
                                        @else
                                            <div class="col-sm-3" style="display: flex;">
                                                <div class="col-sm-1">
                                                    <input type="radio" style="width:1rem;margin:unset !important;"
                                                        value="1" name="DificultyChoose" id="NoDifficulty"
                                                        class="form-control" alt="" />
                                                </div>
                                                <label for="NoDifficulty" style="margin:.45rem .45rem 0 0">بدون
                                                    پیچیدگی</label>
                                            </div>
                                        @endforelse
                                        @if ($Policies->where('SettingKey', '=', 'PasswordDificulty')->firstOrFail()->SettingValue == 2)
                                            <div class="col-sm-3" style="display: flex;">
                                                <div class="col-sm-1">
                                                    <input type="radio" style="width:1rem;margin:unset !important;" checked
                                                        value="2" name="DificultyChoose" id="NAndCDifficulty"
                                                        class="form-control" alt="" />
                                                </div>
                                                <label for="NAndCDifficulty" style="margin:.45rem .45rem 0 0">ترکیب حروف و
                                                    عدد باشد</label>
                                            </div>
                                        @else
                                            <div class="col-sm-3" style="display: flex;">
                                                <div class="col-sm-1">
                                                    <input type="radio" style="width:1rem;margin:unset !important;"
                                                        value="2" name="DificultyChoose" id="NAndCDifficulty"
                                                        class="form-control" alt="" />
                                                </div>
                                                <label for="NAndCDifficulty" style="margin:.45rem .45rem 0 0">ترکیب حروف و
                                                    عدد باشد</label>
                                            </div>
                                        @endforelse
                                        @if ($Policies->where('SettingKey', '=', 'PasswordDificulty')->firstOrFail()->SettingValue == 3)
                                            <div class="col-sm-3" style="display: flex;">
                                                <div class="col-sm-1">
                                                    <input type="radio" style="width:1rem;margin:unset !important;" checked
                                                        value="3" name="DificultyChoose" id="SpecialsDifficulty"
                                                        class="form-control" alt="" />
                                                </div>
                                                <label for="ContainSpecialsDifficulty"
                                                    style="margin:.45rem .45rem 0 0">دارای
                                                    حروف خاص باشد</label>
                                            </div>
                                        @else
                                            <div class="col-sm-3" style="display: flex;">
                                                <div class="col-sm-1">
                                                    <input type="radio" style="width:1rem;margin:unset !important;"
                                                        value="3" name="DificultyChoose" id="SpecialsDifficulty"
                                                        class="form-control" alt="" />
                                                </div>
                                                <label for="ContainSpecialsDifficulty"
                                                    style="margin:.45rem .45rem 0 0">دارای
                                                    حروف خاص باشد</label>
                                            </div>
                                        @endforelse
                                    @else
                                        <div class="col-sm-3" style="display: flex;">
                                            <div class="col-sm-1">
                                                <input type="radio" style="width:1rem;margin:unset !important;" checked
                                                    value="1" name="DificultyChoose" id="NoDifficulty"
                                                    class="form-control" alt="" />
                                            </div>
                                            <label for="NoDifficulty" style="margin:.45rem .45rem 0 0">بدون
                                                پیچیدگی</label>
                                        </div>
                                        <div class="col-sm-3" style="display: flex;">
                                            <div class="col-sm-1">
                                                <input type="radio" style="width:1rem;margin:unset !important;" value="2"
                                                    name="DificultyChoose" id="NAndCDifficulty" class="form-control"
                                                    alt="" />
                                            </div>
                                            <label for="NAndCDifficulty" style="margin:.45rem .45rem 0 0">ترکیب حروف و عدد
                                                باشد</label>
                                        </div>
                                        <div class="col-sm-3" style="display: flex;">
                                            <div class="col-sm-1">
                                                <input type="radio" style="width:1rem;margin:unset !important;" value="3"
                                                    name="DificultyChoose" id="SpecialsDifficulty" class="form-control"
                                                    alt="" />
                                            </div>
                                            <label for="ContainSpecialsDifficulty" style="margin:.45rem .45rem 0 0">دارای
                                                حروف خاص باشد</label>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="form-group row" style="margin-top: 3rem;">
                                    <div class="col-sm-2">
                                        <label>تعداد تلاش ناموفق : </label>
                                    </div>
                                    <div class="col-sm-3" style="display: flex;">
                                        @if ($Policies->where('SettingKey', '=', 'IncorrectAttemptCount')->count() > 0)
                                            <input type="text" class="form-control form-control-user"
                                                id="IncorrectAttemptCount" name="IncorrectAttemptCount" placeholder=""
                                                value="{{ $Policies->where('SettingKey', '=', 'IncorrectAttemptCount')->firstOrFail()->SettingValue ?? '' }}">
                                        @else
                                            <input type="text" class="form-control form-control-user"
                                                id="IncorrectAttemptCount" name="IncorrectAttemptCount" placeholder=""
                                                value="20">
                                        @endforelse
                                    </div>
                                    <div class="col-sm-2" style="display: flex;">
                                        <label>مدت زمان تعلیق کاربر : </label>
                                    </div>
                                    <div class="col-sm-3" style="display: flex;">
                                        @if ($Policies->where('SettingKey', '=', 'LockoutDuration')->count() > 0)
                                            <input type="text" class="form-control form-control-user" id="LockoutDuration"
                                                name="LockoutDuration" placeholder="دقیقه"
                                                value="{{ $Policies->where('SettingKey', '=', 'LockoutDuration')->firstOrFail()->SettingValue ?? '' }}">
                                        @else
                                            <input type="text" class="form-control form-control-user" id="LockoutDuration"
                                                name="LockoutDuration" placeholder="دقیقه" value="5">
                                        @endforelse
                                    </div>
                                    @if ($Policies->where('SettingKey', '=', 'FullLockoutUser')->count() > 0)
                                        @if ($Policies->where('SettingKey', '=', 'FullLockoutUser')->firstOrFail()->SettingValue == 0)
                                            <div class="col-sm-2" style="display: flex;">
                                                <div class="col-sm-1">
                                                    <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                        id="FullLockout" class="form-control" alt=""
                                                        onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                </div>
                                                <label for="FullLockout" style="margin:.45rem .45rem 0 0">تعلیق کامل
                                                    کاربر</label>
                                            </div>
                                        @else
                                            <div class="col-sm-2" style="display: flex;">
                                                <div class="col-sm-1">
                                                    <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                        checked id="FullLockout" class="form-control" alt=""
                                                        onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                </div>
                                                <label for="FullLockout" style="margin:.45rem .45rem 0 0">تعلیق کامل
                                                    کاربر</label>
                                            </div>
                                        @endforelse
                                    @else
                                        <div class="col-sm-2" style="display: flex;">
                                            <div class="col-sm-1">
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="FullLockout" class="form-control" alt=""
                                                    onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                            </div>
                                            <label for="FullLockout" style="margin:.45rem .45rem 0 0">تعلیق کامل
                                                کاربر</label>
                                        </div>
                                    @endforelse
                                    <div class="col-sm-3" style="display: flex;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block">
                                            ذخیره اطلاعات
                                        </button>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                </div>
                                <hr />
                            </form>
                        @endif
                        <div class="alert alert-success alert-dismissible" role="alert" id="successAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="SuccessMessage"></p>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert" id="warningAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="WarningMessage"></p>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="ErrorMessage"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <title>سامانه مدیریت تحقیقات - خط مشی کلمه عبور</title>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('input[type=radio][name=DificultyChoose]').change(function() {
                $("#PasswordDificulty").val(this.value);
            });
            $("#FullLockout").change(function() {
                if ($(this).is(':checked')) {
                    $("#FullLockoutUser").val(1);
                    $("#LockoutDuration").prop('disabled', true);
                } else {
                    $("#FullLockoutUser").val(0);
                    $("#LockoutDuration").prop('disabled', false);
                }
            });
        });
    </script>
@endsection
