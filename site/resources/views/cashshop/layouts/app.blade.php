<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
<html>
<head>
    <meta content="JavaScript" name="vs_defaultClientScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=US">
    <link title="style" href="{{ asset("css/layout.css") }}" type="text/css" rel="stylesheet">
{{--    <link title="style" href="{{ asset("css/shopstyle.css") }}" type="text/css" rel="stylesheet">--}}
    <title>Cabal CashShop</title>
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table width="600" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td align="left"><img src="{{ asset('/images/logo.png') }}" style="position:absolute;top:0px"
                                          height="100"
                                          width="600"/>
                    </td>
                <tr>
                @yield('head')
            </table>
            @yield('content')
        </td>
    </tr>
</table>

</body>
</html>
