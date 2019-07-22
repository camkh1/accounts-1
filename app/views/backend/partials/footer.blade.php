{{HTML::script('backend/melon/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js')}}
{{HTML::script('backend/melon/bootstrap/js/bootstrap.min.js')}}
{{HTML::script('backend/melon/assets/js/libs/lodash.compat.min.js')}}
<!--[if lt IE 9]>
	{{HTML::script('backend/melon/assets/js/libs/html5shiv.js')}}
<![endif]-->
{{HTML::script('backend/melon/plugins/touchpunch/jquery.ui.touch-punch.min.js')}}
{{HTML::script('backend/melon/plugins/event.swipe/jquery.event.move.js')}}
{{HTML::script('backend/melon/plugins/event.swipe/jquery.event.swipe.js')}}
{{HTML::script('backend/melon/assets/js/libs/breakpoints.js')}}
{{HTML::script('backend/melon/plugins/respond/respond.min.js')}}
{{HTML::script('backend/melon/plugins/cookie/jquery.cookie.min.js')}}
{{HTML::script('backend/melon/plugins/slimscroll/jquery.slimscroll.min.js')}}
{{HTML::script('backend/melon/plugins/slimscroll/jquery.slimscroll.horizontal.min.js')}}
{{HTML::script('backend/melon/plugins/sparkline/jquery.sparkline.min.js')}}
{{HTML::script('backend/melon/plugins/typeahead/typeahead.min.js')}}
{{HTML::script('backend/melon/plugins/tagsinput/jquery.tagsinput.min.js')}}
{{HTML::script('backend/melon/plugins/select2/select2.min.js')}}
{{HTML::script('backend/melon/assets/js/app.js')}}
{{HTML::script('backend/melon/assets/js/plugins.js')}}
{{HTML::script('backend/melon/assets/js/plugins.form-components.js')}}
<script>
                $(document).ready(function() {
                    App.init();
                    Plugins.init();
                    FormComponents.init()
                });
            </script>
{{HTML::script('backend/melon/assets/js/custom.js')}}
{{HTML::script('backend/melon/assets/js/demo/form_components.js')}}
{{HTML::script('backend/melon/plugins/noty/packaged/jquery.noty.packaged.min.js')}}
<script>
                $(document).ready(function() {
                    $(".btn-notification").click(function() {
                        var b = $(this);
                        noty({
                            text: b.data("text"),
                            type: b.data("class"),
                            layout: b.data("layout"),
                            timeout: 2000, modal: b.data("modal"),
                            buttons: (b.data("type") != "confirm") ? false : [{addClass: "btn btn-primary", text: "Ok", onClick: function(c) {
                                        c.close();
                                        window.location = "" + b.data("action");
                                    }}, {addClass: "btn btn-danger", text: "Cancel", onClick: function(c) {
                                        c.close();
                                        noty({force: true, text: 'You clicked "Cancel" button', type: "error", layout: b.data("layout")});
                                        setTimeout(function() {
                                            $.noty.closeAll();
                                        }, 4000);
                                    }
                                }]});
                        return false
                    });
                });
            </script>
</body>
</html>