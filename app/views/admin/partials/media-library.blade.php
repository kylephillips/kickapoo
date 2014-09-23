<!-- Translation modal -->
<div class="modal fade media" id="media-library" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn btn-mini cancel-media" data-dismiss="modal">&times;</button>
				<ul class="media-library-tabs">
					<li><a href="#media-existing" class="active">Choose Existing<i class="icon-checkmark"></i></a></li>
					<li><a href="#media-new"><i class="icon-image"></i>Upload Image</a></li>
				</ul>
			</div>
			
			<div id="media-existing" class="modal-body-panel">
				<div class="modal-select">
					<label for="ml-folders">Directory</label>
					<select id="ml-folders" name="ml-folders"></select>
				</div>
				<div class="modal-body loading"></div>
			</div>
			
			<div id="media-new" class="modal-body-upload modal-body-panel" style="display:none;">
				<form action="{{URL::route('media_library_upload')}}" class="dropzone" id="dropzoneForm">
					<div class="dropzone-folder-select">
						<label for="dz-folder">Upload Directory</label>
						<select id="dz-folder" name="folder">
							<option value="page_images">page_images</option>
							<option value="product_images">product_images</option>
						</select>
					</div>
					<input type="file" name="file" class="dropzone-file" />
				</form>
			</div>

			<div class="modal-footer">
				<input type="hidden" id="field-selected">
				<button type="button" class="btn btn-success choose-media" disabled>Use Selected</button>
				<button type="button" class="btn btn-default cancel-media" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->