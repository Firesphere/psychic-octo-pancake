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
        <p>
            $LoginForm
        </p>
    </div>
    <div class="col-5 align-self-end">
        <h2><%t MemberProfiles.REGISTER "Register" %></h2>

        $Form
    </div>
</div>
