<!doctype html>
<html lang="en">
<head>
    <% base_tag %>
    <title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
    $MetaTags('false')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <% if $Canonical %>
        <link rel="canonical" href="$Canonical"/>
    <% end_if %>
    <meta property="og:title" content="Jobhunt helper">
    <meta property="og:url" content="$AbsoluteURL">
    <meta property="og:description"
          content="Keep track of your job applications, add notes, prepare for interviews. All in one place.">
    <meta property="og:type" content="website">
    $SiteConfig.BootswatchTheme
</head>
<body class="$ClassName.ShortName">
<% include Header %>
<main role="main">
    <div class="container">
        $Layout
    </div>
</main>
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemLabel">Add <span class="item-title"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body" id="formcontainer">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<% cached %>
    <footer class="text-muted bg-dark py-4 row footer bg-black small text-center text-white-50 fixed-bottom">
        <% include Footer %>
    </footer>
    <% if $isLive %>
        <script src="https://browser.sentry-cdn.com/7.37.1/bundle.tracing.min.js"
                integrity="sha384-1JKZyj097HID3/SGPzRlmpftSQF7R92wUqwgs4d+PVy/YtHxgNNVQOau9PS4tWFn"
                crossorigin="anonymous"
        ></script>
    <% end_if %>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
<% end_cached %>
$AdblockWarning
</body>
</html>
