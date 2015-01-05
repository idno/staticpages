<?= $this->draw('entity/edit/header'); ?>
<?php

    /* @var \Idno\Core\Template $this */

    if (!empty($vars['object'])) {
        $title = $vars['object']->getTitle();
        $body = $vars['object']->body;
        $forward_url = $vars['object']->forward_url;
    }

    if ($title == 'Untitled') {
        $title = '';
    }

?>
    <form action="<?= $vars['object']->getURL() ?>" method="post" >

        <div class="row">

            <div class="span8 offset2 edit-pane">


                <?php

                    if (empty($vars['object']->_id)) {

                        ?>
                        <h4>New Page</h4>
                    <?php

                    } else {

                        ?>
                        <h4>Edit Page</h4>
                    <?php

                    }

                ?>
                <p>
                    <label>
                        Title<br/>
                        <input type="text" name="title" id="title" placeholder="Give it a title"
                               value="<?= htmlspecialchars($title) ?>" class="span8"/>
                    </label>
                </p>

                

<!-- Forward URL -->
               <!-- <p>
                    <label>
                        Forward URL<br/>
                        <small>Most of the time, you should leave this blank. Include a URL here if you want users to
                            be forwarded to an external page.</small><br>
                        <input type="text" name="forward_url" id="forward_url" placeholder="Website to forward users to"
                               value="<?= htmlspecialchars($forward_url) ?>" class="span8"/>
                    </label>
                </p>-->
<!---->

                <div class="pages span3">
                    <label>
                        Body </label>  
                </div>
                                     
                <p style="text-align: right">        
                    <small>
                        <a href="#" onclick="$('#body').destroy(); $('#plainTextSwitch').hide(); $('#richTextSwitch').show(); return false;" id="plainTextSwitch">Switch to plain text editor</a>
                        <a href="#" onclick="makeRich('#body'); $('#plainTextSwitch').show(); $('#richTextSwitch').hide(); return false;" id="richTextSwitch" style="display:none">Switch to rich text editor</a></small></p>
                    
                        <textarea name="body" id="body" placeholder="Tell your story"
                                  class="span8 bodyInput mentionable wysiwyg"><?= htmlspecialchars($this->autop($body)) ?></textarea>

                    
               

                <?=$this->draw('entity/tags/input');?>
                
                <p>
                    <label>
                        Parent category<br>
                        <select name="category" class="selectpicker">
                            <option <?php if ($vars['category'] == 'No Category') { echo 'selected'; } ?>>No Category</option>
                            <?php

                                if (!empty($vars['categories'])) {
                                    foreach($vars['categories'] as $category) {

                            ?>
                                        <option <?php if ($category == $vars['category']) { echo 'selected'; } ?>><?=htmlspecialchars($category)?></option>
                            <?php

                                    }
                                }

                            ?>
                        </select>
                    </label>
                </p>

                <p class="button-bar " style="text-align: right">
                    <?= \Idno\Core\site()->actions()->signForm('/staticpages/edit') ?>
                    <input type="button" class="btn btn-cancel" value="Cancel" onclick="hideContentCreateForm();"/>
                    <input type="submit" class="btn btn-primary" value="Publish"/>
                    <?= $this->draw('content/access'); ?>
                </p>

            </div>

        </div>
    </form>
    <script>

        /*function postForm() {
         var content = $('textarea[name="body"]').html($('#body').html());
         console.log(content);
         return content;
         }*/

        $(document).ready(function () {
            makeRich('#body');
        })
        ;

        function makeRich(container) {
            $(container).summernote({
                height: "15em",
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fancy', ['link', 'picture']],
                    /* Images forthcoming */
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['codeview', ['fullscreen']]
                ],
                onImageUpload: function(files, editor, welEditable)
                {
                    console.log(files);
                    uploadFileAsync(files[0], editor, welEditable);
                }
            });
        }

        function uploadFileAsync(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "<?=\Idno\Core\site()->config()->getURL()?>file/upload/",
                cache: false,
                contentType: false,
                processData: false,
                success: function (url) {
                    console.log("Success! " + url);
                    editor.insertImage(welEditable, url);
                }
            });
        }
        
        $('.selectpicker').selectpicker();

    </script>
<?= $this->draw('entity/edit/footer'); ?>