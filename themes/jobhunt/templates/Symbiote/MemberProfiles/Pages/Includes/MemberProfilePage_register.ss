<div class="row justify-content-between">
    <% if $FlashMessagesPresent %>
        <% loop $FlashMessages.Limit(1) %>
            <div class="col-12 alert alert-$Type alert-dismissible fade show" role="alert">
                $Message
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <% end_loop %>
    <% end_if %>


    <div class="col-5">
        <h2><%t MemberProfiles.LOGINHEADER "Log in" %></h2>
        <div class="">
            <button type="button" class="h3 btn btn-outline-dark" data-bs-target="#$LoginForm.Name"
                    data-bs-toggle="collapse">$LoginForm.AuthenticatorName</button>
            <button type="button" class="h3 btn btn-outline-dark" data-bs-target="#$TokenLoginForm.Name"
                    data-bs-toggle="collapse">$TokenLoginForm.AuthenticatorName</button>
            <div class="collapse show" id="$LoginForm.Name">
                $LoginForm
            </div>
            <div class="collapse" id="$TokenLoginForm.Name">
                $TokenLoginForm
            </div>
        </div>
    </div>
    <div class="col-5 align-self-end">
        <h2><%t MemberProfiles.REGISTER "Register" %></h2>
        $Content
        $Form
    </div>
</div>
