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
    <% require themedCss("/_resources/themes/jobhunt/dist/css/main") %>

</head>
<body>
<% include Header %>
<% if $FlashMessagesPresent %>
    <% loop $FlashMessages.Limit(1) %>
        <div class="col-12 alert alert-$Type alert-dismissible fade show" role="alert">
            $Message
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <% end_loop %>
<% end_if %>
<main class="login-form">

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">&nbsp;</h1>
            <p>&nbsp;</p>
            <p>&nbsp;<br/>&nbsp;<br/></p>
            <br/>
        </div>
    </section>

    <div class="container py-5">
        <div class="col-sm-12 col-md-6">
            <% if $Title %>
                <h2 class="login-form__title">$Title</h2>
            <% end_if %>

            <% if $Message %>
                <p class="login-form__message
                    <% if $MessageType && not $AlertType %>login-form__message--$MessageType<% end_if %>
                    <% if $AlertType %>login-form__message--$AlertType<% end_if %>"
                >
                    $Message
                </p>
            <% end_if %>

            <% if $Content && $Content != $Message %>
                <div class="login-form__content">$Content</div>
            <% end_if %>

            $Form
        </div>
    </div>
</main>
<footer class="text-muted bg-dark py-4">
    <% include Footer %>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>
</html>
