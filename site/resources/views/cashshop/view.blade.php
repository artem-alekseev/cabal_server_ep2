@extends('cashshop.layouts.app')

@section('content')
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="800" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <td height="25" background="{{ asset('images/Item_Game_Box_01b.gif') }}"
                            style="PADDING-RIGHT: 0px; PADDING-LEFT: 773px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">
                            <img
                                src="{{ asset('images/Item_Game_Box_10.gif') }}" width="11" height="10" border="0"
                                onclick="document.getElementById('logout-form').submit()" style="cursor:pointer;"
                                alt="Item Shop Close"></td>
                    </tr>
                    <tr>
                        <td><img src="/images/Item_Game_Box_02.gif" width="800" height="15"></td>
                    </tr>
                    <tr>
                        <td align="center" background="/images/Item_Game_Box_03.gif">
                            <table width="772" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="178" align="center" valign="top">
                                        <table width="174" height="400" border="0" cellpadding="0"
                                               cellspacing="0">
                                            <tr>
                                                <td width="174" height="50" align="center" class="white">Welcome
                                                    <strong>{{ $user->ID }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="174" height="55"
                                                    background="/images/Item_Game_Box_05.gif" class="teal"
                                                    style="PADDING-RIGHT: 0px; PADDING-LEFT: 15px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">

                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td></td>
                                                            <td class="cloud2"><strong>Bank Alz</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20"><strong class="white"><img
                                                                        src="/images/Item_premium_R_03.gif"
                                                                        width="16" vspace="0"></strong></td>
                                                            <td width="130"><strong
                                                                    class="orange">{{ $user->bank->Alz }}</strong>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top"
                                                    background="/images/Item_Game_Box_06.gif">
                                                    <img src="{{ asset('images/Item_Game_Box_20.gif') }}"
                                                         width="160" height="26"
                                                         border="1"
                                                         style="CURSOR:pointer"
                                                         onclick="javascript:location.href='{{ route('cashshop.view') }}'"
                                                         width="160" height="26" vspace="3" border="0"></br>
                                                    <img src="{{ asset('images/Item_Game_Box_21.gif') }}"
                                                         width="160" height="26"
                                                         border="1"
                                                         style="CURSOR:pointer"
                                                         onclick="javascript:location.href='{{ route('cashshop.index') }}'"
                                                         width="160" height="26" vspace="3" border="0"></br>
                                            </tr>
                                            <tr>
                                                <td height="5"><img src="/images/Item_Game_Box_07.gif"
                                                                    width="174" height="5"></td>
                                            </tr>
                                            <tr>
                                                <td height="5"></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="center" valign="top" style="padding: 5 5 5 0">
                                        <table width="594" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td valign="top"><img src="/images/Item_Box_Img_01.gif"
                                                                      width="594" height="12"></td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="center"
                                                    background="/images/Item_Box_Img_03.gif" height="500">
                                                    <table width="571" border="0" cellspacing="0"
                                                           cellpadding="0">
                                                        <tr>
                                                            <td height="50" colspan="3"
                                                                background="/images/Item_Menu_Bg_00.gif"
                                                                bgcolor="#000000">

                                                                <table width="287" height="50" border="0"
                                                                       cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        @foreach($cashShopCategories as $key => $cashShopCategory)
                                                                            <td align="left"
                                                                                style="PADDING-RIGHT:1px"><img
                                                                                    src="/images/Menu_Item{{ $key }}_{{ request()->get('tab', 1) == $key ? 'On' : 'Off' }}.gif"
                                                                                    name="Image9" width="95"
                                                                                    height="50" border="0"
                                                                                    onclick="javascript:location.href='{{ route('cashshop.view', ['tab' => $key]) }}'"
                                                                                    style="CURSOR:pointer"></td>
                                                                        @endforeach
                                                                    </tr>
                                                                </table>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="1" valign="top"><img
                                                                    src="/images/Item_Box_Img_07.gif" width="1"
                                                                    height="133"></td>
                                                            <td width="569" align="center" valign="top">
                                                                <table width="541" border="0" cellspacing="0"
                                                                       cellpadding="0">
                                                                    <tr>
                                                                        <td valign="top" colspan="3"><img
                                                                                src="/images/Item_premium_inbox1.gif"
                                                                                width="541" height="8"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td background="/images/Item_premium_inbox3.gif"
                                                                            width="8"></td>
                                                                        <td bgcolor="131313" height="420"
                                                                            width="525" valign="top"
                                                                            align="center">

                                                                            <div
                                                                                style="OVERFLOW-y: scroll;bgcolor:red; width:525;height:419">
                                                                                @foreach($shopItems as $shopItem)
                                                                                <table width="500"
                                                                                       cellspacing="4"
                                                                                       cellpadding="0"
                                                                                       border="0">
                                                                                    <tr>
                                                                                        <td width="90"
                                                                                            rowspan="2"><img width="128" height="128"
                                                                                                src="{{ asset($shopItem->Image) }}"/>
                                                                                        </td>
                                                                                        <td valign="top"
                                                                                            align="left"
                                                                                            style="padding-left:8px;padding-top:4px"
                                                                                            colspan="2"><span
                                                                                                class="teal"
                                                                                                style="font-size:14px;font-weight:bold;">{{ $shopItem->Name }}</span><br/><span
                                                                                                class="mini">{{ $shopItem->Description }}</span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="left"
                                                                                            style="padding-left:8px"
                                                                                            width="270"><img
                                                                                                src="/images/Item_premium_R_03.gif"
                                                                                                width="16"
                                                                                                height="12"/><strong
                                                                                                class="orange">{{ $shopItem->Alz }}</strong>
                                                                                            <span
                                                                                                class="mini">Alz</span>
                                                                                        </td>
                                                                                        <td align="right"
                                                                                            width="81"
                                                                                            height="22"><img
                                                                                                src="/images/Item_Purchase_05.gif"
                                                                                                style="CURSOR: pointer"
                                                                                                onclick="javscript:location.href='{{ route('cashshop.buy', ['itemId' => $shopItem->Id]) }}'"
                                                                                                alt="Confirm purchase"
                                                                                                width="81"
                                                                                                height="22"/>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td background="/images/Item_premium_R_04.gif"
                                                                                            width="7" height="1"
                                                                                            colspan="3"
                                                                                            style="padding-right:8px"></td>
                                                                                    </tr>

                                                                                </table>
                                                                                @endforeach
                                                                            </div>
                                                                        </td>
                                                                        <td background="/images/Item_premium_inbox4.gif"
                                                                            width="8"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top" colspan="3"><img
                                                                                src="/images/Item_premium_inbox2.gif"
                                                                                width="541" height="8"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td width="1" valign="top"><img
                                                                    src="/images/Item_Box_Img_07.gif" width="1"
                                                                    height="133"></td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"><img src="/images/Item_Box_Img_02.gif"
                                                                      width="594" height="12"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><img src="/images/Item_Game_Box_04.gif" width="800" height="17"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <script>
        document.body.style.overflow = 'hidden';
    </script>
@endsection
