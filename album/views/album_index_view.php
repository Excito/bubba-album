<div class="ui-albummanager-panel">
	<div id="fn-albummanager-information-panel" class=
		"ui-helper-hidden ui-albummanager-information-panel"></div>

	<div id="fn-albummanager-action-panel" class=
		"ui-helper-hidden ui-action-panel"></div>
</div>

<table id="albumtable" class="ui-table-outline">
	<thead>
		<tr>
			<td colspan="4"></td>
		</tr>

		<tr class=
			"ui-state-default ui-widget-header ui-albummanager-header">
			<th><?=_("Albums")?></th>

			<th><?=_("Created")?></th>

			<th><?=_("Modified")?></th>

			<th></th>
		</tr>

		<tr class="ui-header">
			<td colspan="4" class="ui-albummanager-fake-updir"></td>
		</tr>

		<tr>
			<td colspan="4" class=
				"ui-helper-hidden ui-albummanager-permission-denied">
				<?=_("Permission denied")?>
			</td>
		</tr>
	</thead>
	<tbody>
	</tbody>

	<tfoot>
		<tr class=
			"ui-state-default ui-widget-header ui-albummanager-header">
			<th colspan="4"><?=_("Images")?> <span id="fn-albummanager-image-header-albumname"></span></th>
		</tr>
		<tr id="fn-album-infobox">
			<td>
				<div class="ui-album-title"></div>

				<div class="ui-album-caption"></div>
			</td>

			<td class="ui-album-created"></td>

			<td class="ui-album-modified"></td>

			<td></td>
		</tr>

		<tr>
			<td colspan="4">
				<div id="fn-images" class="ui-album-images"></div>
			</td>
		</tr>
	</tfoot>
</table>

<div id="fn-templates" class="ui-helper-hidden">
	<div class="ui-album-body">
		<div class="ui-album-thumbnail ui-corner-all"></div>

		<div class="ui-album-text">
			<div>
				<span class="ui-album-public ui-helper-hidden"></span>
				<span class="ui-album-title"></span>
			</div>

			<div class="ui-album-caption"></div>

			<div class="ui-album-count"></div>
		</div>
	</div><a class="ui-album-image ui-corner-all"></a>

	<div id="fn-albummanager-create-dialog">
		<h2 class="ui-text-center">
			<?=_("Create album")?>
		</h2>

		<form id="fn-albummanager-create">
			<div class="ui-form-wrapper">
				<div id="fn-albummanager-create-form-step-1" class="step">
					<h3><?=_("Album name and description")?>
					</h3>

					<table>
						<tr>
							<td><label for="fn-albummanager-create-name">
									<?=_("Name")?>
									:</label> <input type="text" id=
								"fn-albummanager-create-name" name="name" class=
								"ui-input-text fn-primary-field" value=
								"New album" /></td>
						</tr>

						<tr>
							<td><label for="fn-albummanager-create-caption">
									<?=_("Description")?>
									:</label> 
								<textarea id="fn-albummanager-create-caption" name="caption" class="ui-input-text"></textarea>
							</td>
						</tr>
					</table>
				</div>

				<div id="fn-albummanager-create-form-step-2" class="step">
					<h3><?=_("Album access rights")?>
					</h3>
					<table><tr><td>
						<div>
							<label for="fn-albummanager-create-public">
								<?=_("Allow anonymous access")?>
								:</label> <input type="checkbox" id=
							"fn-albummanager-create-public" name="public" class=
							"slide" />
						</div>

						<div>
							<table class="ui-table-outline ui-album-usertable">
								<thead>
									<tr class=
										"ui-state-default ui-widget-header ui-albummanager-header">
										<td></td>
	
										<td><?=_("Access allowed")?></td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<hr></hr>
						<button class="ui-button ui-state-default ui-corner-all ui-button-text-only" id="fn-albummanager-create-form-step-button-branch-adduser" type="button" value="fn-albummanager-create-form-step-offstep-adduser"><?=_("Manage album users")?></button>
					</td></tr></table>
						
				</div>

				<div id="fn-albummanager-create-form-step-3" class="step submit_step">
					<h3><?=_("Select images/folders to be included in the album")?>
					</h3>

					<div class="fn-placeholder-filemanager"></div>
				</div>
			</div>
		</form>
	</div>

	<div id="fn-albummanager-delete-dialog">
		<h2><?=_("Delete selected images/albums?")?>
		</h2>
	</div>

	<div id="fn-albummanager-modify-dialog">
		<h2><?=_("Modify name and caption")?>
		</h2>

		<table>
			<tr>
				<td><label for="fn-albummanager-modify-name">
						<?=_("Name")?>
						:</label> <input type="text" id=
					"fn-albummanager-modify-name" name="name" class=
					"ui-input-text fn-primary-field" value="New album" /></td>
			</tr>

			<tr>
				<td><label for="fn-albummanager-modify-caption">
						<?=_("Description")?>
						:</label> 
					<textarea id="fn-albummanager-modify-caption" name=
						"caption" class="ui-input-text">
				</textarea></td>
			</tr>
		</table>
	</div>

	<div id="fn-albummanager-perm-dialog" class="step">
		<h2><?=_("Album permissions")?>
		</h2>

		<table class="ui-table-outline ui-album-perm-public">
			<tbody>
			<tr>
				<td>
				<div>
					<label for="fn-albummanager-perm-public">
						<?=_("Allow anonymous access")?>
						:</label>
					</td>
					<td>
					<input type="checkbox" class="slide" id="fn-albummanager-perm-public" name="public" class="" />
				</div>
			</td>
		</tr>
		<tr>
			<td>

				<div>
					<label for="fn-albummanager-perm-recursive">
						<?=_("Apply changes recursively")?>
						:</label>
							</td>
							<td>
						<input type="checkbox" class="slide" id="fn-albummanager-perm-recursive" name="recursive" checked="checked" class="" />
				</div>
			</td>
		</tr>
	</tbody>
	</table>

		<div>
			<table class="ui-table-outline ui-album-usertable">
				<thead>
					<tr class=
						"ui-state-default ui-widget-header ui-albummanager-header">
						<td><?=_("User")?></td>

						<td><?=_("Access allowed")?></td>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>

	<div id="fn-albummanager-users-dialog">
		<h2><?=_("Manage album users")?>
		</h2>

		<div class=
			"ui-albummanager-buttonbar-wrapper ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix ui-albummanager-buttonbar ui-albummanager-subbuttonbar"
			id="fn-albummanager-users-dialog-buttons">
			<button id="fn-albummanager-users-dialog-button-add" disabled="disabled"><?=
				_("Add user")
			?></button><button id="fn-albummanager-users-dialog-button-edit" disabled="disabled"><?=
				_("Edit user")
			?></button><button id="fn-albummanager-users-dialog-button-delete" disabled="disabled"><?=
				_("Delete user")
			?></button>
		</div>

		<table class="ui-table-outline ui-album-usertable">
			<thead>
				<tr class="ui-state-default ui-widget-header ui-albummanager-header">
					<td><?=_("Album users")?></td>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

	<div id="fn-albummanager-add-dialog">
		<h2><?=_("Select directories and images to add to current album")?>
		</h2>

		<div class="fn-placeholder-filemanager"></div>
	</div>

	<form id="fn-albummanager-users-edit-template">

		<div class="ui-helper-inline">
			<label for="fn-albummanager-users-edit-username">
				<?=_("Username")?>
			</label>
			<br/>
			<input id="fn-albummanager-users-edit-username" type=
			"text" name="username" disabled="disabled" />
			
			<span id="fn-albummanager-users-edit-username"></span>
		</div>

		<div class="ui-helper-inline">
			<label for="fn-albummanager-users-edit-realname">
				<?=_("Name")?>
			</label>
			<br/>
			<input id="fn-albummanager-users-edit-realname" type=
			"text" name="realname" />
		</div>

		<div class="ui-helper-inline">
			<label for="fn-albummanager-users-edit-password1">
				<?=_("Password")?>
			</label>
			<br/>
			<input id="fn-albummanager-users-edit-password1"
			type="password" name="password1" />
		</div>


		<div class="ui-helper-inline">
			<label for="fn-albummanager-users-edit-password2">
				<?=_("Confirm")?>
			</label>
			<br/>
			<input id="fn-albummanager-users-edit-password2"
			type="password" name="password2" />
		</div>

		<div class="ui-album-users-actions">
			<button id="fn-albummanager-users-edit-cancel" type="button"></button><button id="fn-albummanager-users-edit-ok" type="button"></button>
		</div>



	</form>

	<form id="fn-albummanager-users-add-template">

		<div class="ui-helper-inline">
			<label for="fn-albummanager-users-add-username">
				<?=_("Username")?>
			</label>
			<br/>
			<input id="fn-albummanager-users-add-username" type=
			"text" name="username" />
		</div>

		<div class="ui-helper-inline">
			<label for="fn-albummanager-users-add-realname">
				<?=_("Name")?>
			</label>
			<br/>
			<input id="fn-albummanager-users-add-realname" type=
			"text" name="realname" />
		</div>

		<div class="ui-helper-inline">
			<label for="fn-albummanager-users-add-password1">
				<?=_("Password")?>
			</label>
			<br/>
			<input id="fn-albummanager-users-add-password1"
			type="password" name="password1" />
		</div>


		<div class="ui-helper-inline">
			<label for="fn-albummanager-users-add-password2">
				<?=_("Confirm")?>
			</label>
			<br/>
			<input id="fn-albummanager-users-add-password2"
			type="password" name="password2" />
		</div>

		<div class="ui-album-users-actions">
			<button id="fn-albummanager-users-add-cancel" type="button">
			</button><button id="fn-albummanager-users-add-ok" type="button">
			</button>
		</div>

	</form>


	<table id="fn-filemanager" class="ui-table-outline">
		<thead>
			<tr class="ui-state-default ui-widget-header">
				<th></th>

				<th><?=_("Name")?></th>

				<th><?=_("Date")?></th>

				<th><?=_("Size")?></th>

				<th></th>
			</tr>

			<tr class="ui-header">
				<td colspan="5" class="ui-filemanager-fake-updir"></td>
			</tr>

			<tr>
				<td colspan="5" class=
					"ui-helper-hidden ui-filemanager-permission-denied">
					<?=_("Permission denied")?>
				</td>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
