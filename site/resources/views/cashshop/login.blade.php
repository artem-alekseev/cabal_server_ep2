@extends('cashshop.layouts.app')

@section('head')
    <td align="center">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            Login: <input type="text" class="editbox" required name="ID" size="10">
            Pass: <input type="password" name="password" required class="editbox" size="10"/>
            <input type="submit" name="login" value="Log in" class="button"/>
        </form>
    </td>
@endsection
@section('content')
    <p>There are currently <span style="font-size:16px;font-weight:bold">{{ $onlineAccountCount }}</span> people online
        right
        now.</p>
    <p>Registered accounts: <span style="font-size:16px;font-weight:bold">{{ $accountCount }}</span> | Characters
        created: <span style="font-size:16px;font-weight:bold">{{ $charactersCount }}</span></p>

    <p style="font-size:24px;font-weight:bold">Account registration</p>

    <p>Username and password must be minimum 6 chars, letters and numbers only.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <table cellspacing="4" cellpadding="0" border="0">
            <tr>
                <td align="right">Login:</td>
                <td><input type="text" class="editbox" name="id" value="{{ old('id') }}"></td>
            </tr>
            <tr>
                <td align="right">Pass:</td>
                <td><input type="password" name="password" class="editbox"></td>
            </tr>
            <tr>
                <td align="right">Confirm pass:</td>
                <td><input type="password" name="password_confirmation" class="editbox"></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><input type="submit" value="Register account" class="button"></td>
            </tr>
        </table>
    </form>
@endsection
