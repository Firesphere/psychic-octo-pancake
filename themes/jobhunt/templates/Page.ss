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
    <meta property="og:title" content="My Job Quest: Jobhunt helper">
    <meta property="og:url" content="$AbsoluteURL">
    <meta property="og:description"
          content="Keep track of your job applications, add notes, prepare for interviews. All in one place.">
    <meta property="og:type" content="website">
    $SiteConfig.BootswatchTheme
</head>
<body class="$ClassName.ShortName">
<% include Header %>
<main role="main" class="py-4 container<% if $ClassName.ShortName == 'KanbanPage' %>-fluid<% end_if %>">
    <% if $FlashMessagesPresent %>
        <% loop $FlashMessages.Limit(1) %>
            <div class="alert alert-$Type alert-dismissible fade show" role="alert">
                $Message
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <% end_loop %>
    <% end_if %>
    $Layout
    <div class="spacer pb-5 row">&nbsp;</div>
</main>
<% if $CurrentUser %>
    <button class="btn btn-light position-sticky bottom-50 start-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNotes" aria-controls="offcanvasNotes">
        <i class="bi bi-journal-text"></i>
    </button>

    <% include OffCanvas %>
<% end_if %>
<% include Modal %>
<footer class="bg-light-subtle py-2 footer text-center fixed-bottom">
    <% include Footer %>
</footer>
$AdblockWarning
</body>
</html>
