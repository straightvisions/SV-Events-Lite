<?php
/**
 * @version     1.0.0 (file)
 * @package     com_sv_events_lite
 * @license     GNU General Public License Version 2 or later;
 * @author      Dennis Heiden <info@straightvisions.com> - straightvisions.com
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'administrator/components/com_sv_events_lite/assets/css/style.css');
$document->addStyleSheet(JUri::root() . 'media/com_sv_events_lite/css/list.css');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_sv_events_lite');
$saveOrder = $listOrder == 'a.`ordering`';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_sv_events_lite&task=categories.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'categoryList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();



?>
<script type="text/javascript">
	Joomla.orderTable = function () {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	};

	jQuery(document).ready(function () {
		jQuery('#clear-search-button').on('click', function () {
			jQuery('#filter_search').val('');
			jQuery('#adminForm').submit();
		});
	});
</script>

<?php

// Joomla Component Creator code to allow adding non select list filters
if (!empty($this->extra_sidebar))
{
	$this->sidebar .= $this->extra_sidebar;
}

?>

<form action="<?php echo JRoute::_('index.php?option=com_sv_events_lite&view=categories'); ?>" method="post"
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search"
						   class="element-invisible">
						<?php echo JText::_('JSEARCH_FILTER'); ?>
					</label>
					<input type="text" name="filter_search" id="filter_search"
						   placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>"
						   value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
						   title="<?php echo JText::_('JSEARCH_FILTER'); ?>"/>
				</div>
				<div class="btn-group pull-left">
					<button class="btn hasTooltip" type="submit"
							title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>">
						<i class="icon-search"></i></button>
					<button class="btn hasTooltip" id="clear-search-button" type="button"
							title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>">
						<i class="icon-remove"></i></button>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit"
						   class="element-invisible">
						<?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?>
					</label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="directionTable"
						   class="element-invisible">
						<?php echo JText::_('JFIELD_ORDERING_DESC'); ?>
					</label>
					<select name="directionTable" id="directionTable" class="input-medium"
							onchange="Joomla.orderTable()">
						<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
						<option value="asc" <?php echo $listDirn == 'asc' ? 'selected="selected"' : ''; ?>>
							<?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?>
						</option>
						<option value="desc" <?php echo $listDirn == 'desc' ? 'selected="selected"' : ''; ?>>
							<?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?>
						</option>
					</select>
				</div>
				<div class="btn-group pull-right">
					<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
					<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
						<option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
						<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
					</select>
				</div>
			</div>
			<div class="clearfix"></div>
			<table class="table table-striped" id="categoryList">
				<thead>
				<tr>
					<?php if (isset($this->items[0]->ordering)): ?>
						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.`ordering`', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
						</th>
					<?php endif; ?>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value=""
							   title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<?php if (isset($this->items[0]->state)): ?>
						<th width="1%" class="nowrap center">
                                                <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.`state`', $listDirn, $listOrder); ?>
                                        </th>
					<?php endif; ?>

					<th width="1%" class="nowrap center hidden-phone">
				<?php echo JHtml::_('grid.sort',  'COM_SV_EVENTS_LITE_CATEGORY_ID', 'a.`category_id`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('grid.sort',  'COM_SV_EVENTS_LITE_CATEGORY_NAME', 'a.`name`', $listDirn, $listOrder); ?>
				</th>
                                <!--
                                <th class='left'>
				<?php // echo JHtml::_('grid.sort',  'Kategorietyp', 'a.`type`', $listDirn, $listOrder); ?>
				</th>-->
                          
                                <th width="10%" class="nowrap hidden-phone">
                                    <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
                                </th>
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create', 'com_sv_events_lite');
					$canEdit    = $user->authorise('core.edit', 'com_sv_events_lite');
					$canCheckin = $user->authorise('core.manage', 'com_sv_events_lite');
					$canChange  = $user->authorise('core.edit.state', 'com_sv_events_lite');
					?>
					<tr class="row<?php echo $i % 2; ?>">

						<?php if (isset($this->items[0]->ordering)) : ?>
							<td class="order nowrap center hidden-phone">
								<?php if ($canChange) :
									$disableClassName = '';
									$disabledLabel    = '';

									if (!$saveOrder) :
										$disabledLabel    = JText::_('JORDERINGDISABLED');
										$disableClassName = 'inactive tip-top';
									endif; ?>
									<span class="sortable-handler hasTooltip <?php echo $disableClassName ?>"
										  title="<?php echo $disabledLabel ?>">
							<i class="icon-menu"></i>
						</span>
									<input type="text" style="display:none" name="order[]" size="5"
										   value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
								<?php else : ?>
									<span class="sortable-handler inactive">
							<i class="icon-menu"></i>
						</span>
								<?php endif; ?>
							</td>
						<?php endif; ?>
						<td class="hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->category_id); ?>
						</td>
						<?php if (isset($this->items[0]->state)): ?>
						<td class="center">
                                                        <?php echo JHtml::_('jgrid.published', $item->state, $i, 'categories.', $canChange, 'cb'); ?>
                                                </td>
						<?php endif; ?>
                                                
                                                <td>
                                                    <?php echo $item->category_id; ?>
                                                </td>
                                                
                                                <td>
                                                    <?php if (isset($item->checked_out) && $item->checked_out && ($canEdit || $canChange)) : ?>
                                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'categories.', $canCheckin); ?>
                                                    <?php endif; ?>
                                                    <?php if ($canEdit) : ?>
                                                            <a href="<?php echo JRoute::_('index.php?option=com_sv_events_lite&task=category.edit&category_id='.(int) $item->category_id); ?>">
                                                            <?php echo $this->escape($item->name); ?></a>
                                                    <?php else : ?>
                                                            <?php echo $this->escape($item->name); ?>
                                                    <?php endif; ?>
                                                </td>
                                                
                                                <td class="small hidden-phone">
						<?php if ($item->language == '*'):?>
                                                        <?php echo JText::alt('JALL', 'language'); ?>
                                                <?php else:?>
                                                        <?php echo $item->language_title ? JHtml::_('image', 'mod_languages/' . $item->language_image . '.gif', $item->language_title, array('title' => $item->language_title), true) . '&nbsp;' . $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                                <?php endif;?>
                                                </td>
                                                
                                                <?php /*
                                                <td>
                                                    
                                                    <?php
                                                    
                                                    switch($item->type){
                                                        
                                                        case '0':
                                                            echo 'Produktkategorie';
                                                            break;
                                                        case '1':
                                                            echo 'Besucherkategorie';
                                                            break;
                                                        case '2':
                                                            echo 'ProduktOBERkategorie';
                                                            break;
                                                        case '3':
                                                            echo 'Themenkategorie';
                                                            break;
   
                                                    }
                                                    
                                                    ?>
                                                </td>
                                                 * */?>
                                                 
                        

					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
			<?php echo JHtml::_('form.token'); ?>
		</div>
</form>        
