@extends('cashshop.layouts.app')

@section('content')
    <table width="800" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <td height="25" background="{{ asset('images/Item_Game_Box_01b.gif') }}"
                style="PADDING-RIGHT: 0px; PADDING-LEFT: 773px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px"><img
                    src="{{ asset('images/Item_Game_Box_10.gif') }}" width="11" height="10" border="0"
                    onclick="document.getElementById('logout-form').submit()" style="cursor:pointer;"
                    alt="Item Shop Close"></td>
        </tr>
        <tr>
            <td><img src="{{ asset('images/Item_Game_Box_02.gif') }}" width="800" height="15"></td>
        </tr>
        <tr>
            <td align="center" background="{{ asset('images/Item_Game_Box_03.gif') }}">
                <table width="772" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="178" align="center" valign="top">
                            <table width="174" height="400" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="174" height="50" align="center" class="white">Welcome
                                        <strong>{{ $user->ID }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="174" height="55" background="{{ asset('images/Item_Game_Box_05.gif') }}"
                                        class="teal"
                                        style="PADDING-RIGHT: 0px; PADDING-LEFT: 15px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">

                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td></td>
                                                <td class="cloud2"><strong>Bank Alz</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="20"><strong class="white"><img
                                                            src="{{ asset('images/Item_premium_R_03.gif') }}" width="16"
                                                            vspace="0"></strong></td>
                                                <td width="130"><strong class="orange">{{ $user->bank->Alz }}</strong>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top"
                                        background="{{ asset('images/Item_Game_Box_06.gif') }}">
                                        <img src="{{ asset('images/Item_Game_Box_20.gif') }}" width="160" height="26"
                                             border="1"
                                             style="CURSOR:pointer"
                                             onclick="javascript:location.href='{{ route('cashshop.view') }}'"
                                             width="160" height="26" vspace="3" border="0"></br>
                                        <img src="{{ asset('images/Item_Game_Box_21.gif') }}" width="160" height="26"
                                             border="1"
                                             style="CURSOR:pointer"
                                             onclick="javascript:location.href='{{ route('cashshop.index') }}'"
                                             width="160" height="26" vspace="3" border="0"></br>
                                        @if($user->isAdmin)
                                            <img src="{{ asset('images/Item_Game_Box_22.gif') }}" width="160" height="26"
                                                 border="1"
                                                 style="CURSOR:pointer"
                                                 onclick="javascript:location.href='{{ route('home') }}'"
                                                 width="160" height="26" vspace="3" border="0"></br>
                                        @endif
                                </tr>
                                <tr>
                                    <td height="5"><img src="{{ asset('images/Item_Game_Box_07.gif') }}" width="174"
                                                        height="5"></td>
                                </tr>
                                <tr>
                                    <td height="5"></td>
                                </tr>
                            </table>
                        </td>
                        <td align="center" valign="top" style="padding: 5 5 5 0">

                            <table width="594" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td valign="top"><img src="{{ asset('images/Item_Box_Img_01.gif') }}" width="594"
                                                          height="12"></td>
                                </tr>
                                <tr>
                                    <td valign="top" align="center"
                                        background="{{ asset('images/Item_Box_Img_03.gif') }}" height="500"
                                        style="padding-top:8px">
                                        <table width="571" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="569" align="center" valign="top">
                                                    <table width="554" cellspacing="0" cellpadding="2"
                                                           style="border:#333333 1px solid" border="0">
                                                        <tr>
                                                            <td colspan="2" align="center"
                                                                style="background-color:#333333" class="white"><strong>Account
                                                                    details</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="120"
                                                                style="padding-left:8px;border-bottom:#333333 1px dashed"
                                                                class="cloud2"><strong>Account name</strong></td>
                                                            <td style=";border-bottom:#333333 1px dashed">{{ $user->ID }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:8px;border-bottom:#333333 1px dashed"
                                                                class="cloud2"><strong>Joined</strong></td>
                                                            <td style=";border-bottom:#333333 1px dashed">{{ $user->CreateDate->format("Y-m-d") }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:8px" class="cloud2"><strong>Total
                                                                    Play Time</strong></td>
                                                            <td>{{ round($user->PlayTime/60, 2) }} hours</td>
                                                        </tr>
                                                    </table>
                                                    <br/>

                                                    <table width="554" cellspacing="0" cellpadding="2"
                                                           style="border:#333333 1px solid" border="0">
                                                        <tr>
                                                            <td colspan="3" align="center"
                                                                style="background-color:#333333" class="white"><strong>Alz</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="120"
                                                                style="padding-left:8px;border-bottom:#333333 1px dashed"
                                                                class="cloud2"><strong>Warehouse Alz</strong></td>
                                                            <td style="border-bottom:#333333 1px dashed">{{ $user->warehouse->Alz ?? 0 }}</td>
                                                            @if (!$user->Login)
                                                                <form method="post"
                                                                      action="{{ route('cashshop.deposit') }}">
                                                                    @csrf
                                                                    <td style="border-bottom:#333333 1px dashed">
                                                                        <input type="text" size="8" name="Alz"
                                                                               class="editbox">
                                                                        <button type="submit" class="button">Deposit
                                                                        </button>
                                                                    </td>
                                                                </form>
                                                            @else
                                                                <td style="border-bottom:#333333 1px dashed"></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:8px; border-bottom:#333333 1px dashed"
                                                                class="cloud2"><strong>Bank Alz</strong></td>
                                                            <td width="120" style="border-bottom:#333333 1px dashed">
                                                                {{ $user->bank->Alz }}
                                                            </td>
                                                            @if (!$user->Login)
                                                                <form method="post"
                                                                      action="{{ route('cashshop.withdraw') }}">
                                                                    @csrf
                                                                    <td style="border-bottom:#333333 1px dashed">
                                                                        <input type="text" size="8" name="Alz"
                                                                               class="editbox">
                                                                        <button type="submit" class="button">Withdraw
                                                                        </button>
                                                                    </td>
                                                                </form>
                                                            @else
                                                                <td style="border-bottom:#333333 1px dashed"></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="mini" colspan="3">You can only
                                                                transfer Alz when not online.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top"><img src="{{ asset('images/Item_Box_Img_02.gif') }}" width="594"
                                                          height="12"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><img src="{{ asset('images/Item_Game_Box_04.gif') }}" width="800" height="17"></td>
        </tr>
    </table>
@endsection
