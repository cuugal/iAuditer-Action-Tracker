<h4>Your request to view the audit has been submitted to iAuditor.</h4>
<p>Please click the refresh button below, and when the audit is available in iAuditor it will load in this screen.</p>
<?php if(isset($status)):?>
<p>Status: <?=$status; ?></p>
<?php endif; ?>
<?php if(isset($error)):?>
    <p>Status: <?=$error; ?></p>
<?php endif; ?>
<a href="/inspection/request/<?=$audit_id;?>/<?=$request_id;?>" class="btn btn-primary">Refresh</a>