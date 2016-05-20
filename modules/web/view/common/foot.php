        </div>
    </div>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;2016&nbsp;西安小木匠网络科技有限公司&nbsp;All Rights Reserved</p>

        <?php foreach($this->js as $js): ?>
        <script  src="<?php echo $this->cdn($js);?>"></script>
    <?php endforeach;?>
    </body>
</html>