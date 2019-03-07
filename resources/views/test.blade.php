<div class="panel-group" role="tablist">
    <div class="panel panel-primary">
        <div class="panel-heading" id="collapseListGroupHeading2" data-toggle="collapse" data-target="#collapseListGroup2" role="tab" >
            <h4 class="panel-title">
                分组2
            </h4>
        </div>
        <div id="collapseListGroup2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading2">
            <ul class="list-group">
                <li class="list-group-item">
                    2
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    $(function(){
        $(".panel-heading").click(function(e){
            /*切换折叠指示图标*/
            $(this).find("span").toggleClass("glyphicon-chevron-down");
            $(this).find("span").toggleClass("glyphicon-chevron-up");
        });
    });
</script>