    <?php
        $paramsQuery = $this->params->query;
        if(!is_array($paramsQuery))
        {
            $paramsQuery = array();
        }
        $paramsQuery['url'] = ( isset($paramsQuery['url']) ) ? $paramsQuery['url'] : '';
        $url = $paramsQuery['url'];
        unset($paramsQuery['url']);
        $params = $paramsQuery;

        $mobile_url = '/' . $url . '?' . http_build_query( array_merge( $params, array( 'forcedLayout' => 'mobile' ) ) );
        $desktop_url = '/' . $url . '?' . http_build_query( array_merge( $params, array( 'forcedLayout' => 'desktop' ) ) );
    ?>

    <?php if($is_mobile): ?>
        <div class="switch_mobile"><?= $this->Html->link('Plná verzia stránky', $desktop_url, array('target' => '', 'class' => '')) ?></div>
    <?php else: ?>
        <div class="switch_full"><?= $this->Html->link('Mobilná verzia stránky', $mobile_url, array('target' => '', 'class' => '')) ?></div>
    <?php endif; ?>
    