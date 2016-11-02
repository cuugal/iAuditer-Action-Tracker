<style>

    /*
    PDFObject appends the classname "pdfobject-container" to the target element.
    This enables you to style the element differently depending on whether the embed was successful.
    */
    .pdfobject-container {
        width: 100%;
        max-width: 600px;
        height: 600px;
        margin: 2em 0;
    }

    /* PDFObject automatically assigns the class name "pdfobject" to the <embed> element */
    .pdfobject { border: solid 1px #666; }

</style>

<div id="pdf1"></div>
<script>PDFObject.embed("<?=base_url();?>tmp/<?=$audit_id;?>.pdf", "#pdf1");</script>

