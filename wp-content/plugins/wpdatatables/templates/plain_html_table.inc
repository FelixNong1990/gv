<?php
/**
* Template file for the plain HTML table
* phpDataTables Module
* 
* @author cjbug@ya.ru
* @since 10.10.2012
*
**/
?>
<?php if($table->getFilteringForm()) { ?>
<div class="wpDataTables wpDataTablesFilter">
	<div id="filterBox_<?php echo $table->getId()?>" class="wpDataTableFilterBox">
	    <?php foreach( $table->getColumns() as $key=>$column) { ?>
	    	<?php if($column->getFilterType()->type != 'null') { ?>
	    	<div class="wpDataTableFilterSection" id="<?php echo $table->getId().'_'.$key.'_filter' ?>_sections">
		    	<label><?php echo $column->getHeader() ?>:</label>
				<div id="<?php echo $table->getId().'_'.$key.'_filter' ?>"></div>
			</div>
			<?php } ?>
	    <?php } ?>
	</div>
</div>
<?php } ?>

<table id="<?php echo $table->getId() ?>" class="<?php echo $table->getClasses() ?> wpDataTable" style="<?php echo $table->getStyle() ?> <?php if( $table->columnsFixed() ) { ?>position: relative;<?php } ?>" data-description='<?php echo $table->getJsonDescription(); ?>'>
	<?php if( $table->headerVisible() ) { ?>
    <thead>
	<tr>
		<?php $expandShown = false; ?>
	    <?php foreach($table->getColumns() as $column) { ?>
		<th <?php if(!$expandShown && $column->isVisibleOnMobiles()){ ?>data-class="expand"<?php $expandShown = true; } ?> <?php if($column->getHiddenAttr()) { ?>data-hide="<?php echo $column->getHiddenAttr() ?>"<?php } ?> class="header <?php if( $column->sortingEnabled() ) { ?>sort<?php } ?> <?php echo $column->getClasses(); ?>" style="<?php echo $column->getStyle(); ?>"><?php echo $column->getHeader(); ?></th>
	    <?php } ?>
		<th>Options</th>
	</tr>
    </thead>
	<?php } ?>
    <?php if( $table->footerVisible() ||  ($table->advancedFilterEnabled() && (get_option('wdtRenderFilter') == 'footer')) ) { ?>
    <tfoot>
	<tr <?php if($table->getFilteringForm()) { ?>style="display: none"<?php } ?>>
	    <?php foreach( $table->getColumns() as $column) { ?>
		<td class="header <?php if( $column->sortingEnabled() ) { ?>sort<?php } ?> <?php echo $column->getClasses(); ?>" style="<?php echo $column->getStyle(); ?>"><?php echo $column->getHeader(); ?></td>
	    <?php } ?>
	</tr>
    </tfoot>
    <?php } ?>
    <tbody>
    <?php $pdt_row_index = 0; ?>
	<?php foreach( $table->getRows() as $row) { ?>
	<tr class="<?php echo $row->getClasses(); ?>" style="<?php echo $row->getStyle(); ?>" id="<?php echo $row->getId() ?>">
	    <?php foreach( $table->getColumnsByKeys() as $column_key=>$column ) { ?>
	    <?php $cell = $row->getCell( $column_key ); ?>
		<td class="<?php echo $cell->getClasses() ?>" style="<?php echo $column->getStyle().' '.$cell->getStyle(); ?>">
			<?php echo $table->getFormattedCellVal( $cell, $column_key ); ?>
		</td>
	    <?php } ?>
	</tr>
        <?php $pdt_row_index++; ?>
	<?php } ?>
    </tbody>
    
</table>

<br/><br/>

<?php if($table->isEditable()) { ?>

<button id="edit_<?php echo $table->getId() ?>" class="edit_table DTTT_button DTTT_button_edit" disabled="disabled"><span>Edit</span></button>
<button id="new_<?php echo $table->getId() ?>" class="new_table_entry DTTT_button DTTT_button_new"><span>New</span></button>
<button id="delete_<?php echo $table->getId() ?>" class="delete_table_entry  DTTT_button DTTT_button_delete" disabled="disabled"><span>Delete</span></button>

<div id="<?php echo $table->getId() ?>_edit_dialog" style="display: none" title="Edit">
	<table>
	<thead>
	<tr>
	<th style="width: 20%"></th>
	<th style="width: 80%"></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach( $table->getColumnsByKeys() as $column_key=>$column ) { ?>
	<tr <?php if($column_key == $table->getIdColumnKey()) { ?>style="display: none" class="idRow"<?php } ?>>
		<td><label for="<?php echo $table->getId() ?>_<?php echo $column_key ?>"><?php echo $column->getHeader(); ?>:</label></td>
		<?php $possibleValues = $column->getPossibleValues(); ?>
		<td>
		<?php if($column->getInputType() == 'textarea') { ?>
			<textarea data-input_type="<?php echo $column->getInputType();?>" class="editDialogInput" id="<?php echo $table->getId() ?>_<?php echo $column_key ?>" data-key="<?php echo $column_key ?>" rows="3" columns="50"></textarea>
		<?php } elseif(($column->getInputType() == 'selectbox') || ($column->getInputType() == 'multi-selectbox')) { ?>
			<select id="<?php echo $table->getId() ?>_<?php echo $column_key ?>" data-input_type="<?php echo $column->getInputType();?>" data-key="<?php echo $column_key ?>" class="editDialogInput" <?php if($column->getInputType() == 'multi-selectbox') { ?>multiple="multiple"<?php } ?> >
				<?php foreach($possibleValues as $possibleValue) { ?>
				<option value="<?php echo $possibleValue ?>"><?php echo $possibleValue ?></option>
				<?php } ?>
			</select>
		<?php } elseif($column->getInputType() == 'attachment') { ?>
		    <span class="fileinput-button">
		        <span class="btn">Upload attachment</span>
		        <input class="fileupload_<?php echo $table->getId() ?>" data-key="<?php echo $column_key ?>" type="file" name="files[]" />
		        <input type="hidden" id="<?php echo $table->getId() ?>_<?php echo $column_key ?>" data-key="<?php echo $column_key ?>" data-input_type="<?php echo $column->getInputType();?>" class="editDialogInput" />
		    </span>
		    <div id="progress_<?php echo $table->getId() ?>_<?php echo $column_key ?>" class="progress" style="width: 200px">
		        <div class="progress-bar progress-bar-success"></div>
		    </div>
		     <div id="files_<?php echo $table->getId() ?>_<?php echo $column_key ?>" class="files" style="width: 250px;"></div>
		<?php } else { ?>
			<input type="text" value="" id="<?php echo $table->getId() ?>_<?php echo $column_key ?>" data-key="<?php echo $column_key ?>" data-input_type="<?php echo $column->getInputType();?>" class="editDialogInput <?php if($column->getDataType() == 'float') { ?>maskMoney<?php } ?> <?php if($column->getInputType() == 'date') { ?>datepicker<?php } ?>" />
		<?php } ?>
		</td>
	<?php } ?>
	</tbody>
	</table>
	<button id="<?php echo $table->getId() ?>_close_edit_dialog" class="btn">Cancel</button>
	<button id="<?php echo $table->getId() ?>_prev_edit_dialog" class="btn">&lt;&lt; Prev</button>
	<button id="<?php echo $table->getId() ?>_next_edit_dialog" class="btn">Next &gt;&gt;</button>
	<button id="<?php echo $table->getId() ?>_apply_edit_dialog" class="btn">Apply</button>
	<button id="<?php echo $table->getId() ?>_ok_edit_dialog" class="btn">OK</button>
</div>
<?php } ?>