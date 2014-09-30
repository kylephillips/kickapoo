<!-- Translation modal -->
<div class="modal fade media" id="media-library" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn btn-mini cancel-media" data-dismiss="modal">&times;</button>
				<ul class="media-library-tabs">
					<li><a href="#media-existing" class="active">Media Library</a></li>
					<li><a href="#media-new">Upload Image</a></li>
				</ul>
			</div>
			
			<div id="media-existing" class="modal-body-panel">
				<div class="modal-select">
					<label for="ml-folders">Directory</label>
					<select id="ml-folders" name="ml-folders"></select>
					<p class="ml-chosen-image">Choose your image.</p>
				</div>
				<div class="modal-body ml-body loading"></div>
				<div class="ml-image-info">
					<div class="ml-image-info-default">
						<i class="icon-admin-image"></i> Select an Image
					</div>
					<div class="ml-image-info-selected" style="display:none;">
						<h4>Image Details</h4>
						<div class="alert alert-info" style="display:none;" id="ml-image-details-saved"></div>
						<p>
							<span id="ml-image-title"></span>
						</p>
						<p>
							<label for="ml-image-alt">Alt Text</label>
							<input type="text" id="ml-image-alt" name="ml-image-alt">
						</p>
						<p>
							<label for="ml-image-caption">Image Caption</label>
							<textarea name="ml-image-caption" id="ml-image-caption"></textarea>
						</p>
						<p>
							<input type="hidden" name="ml-image-id" id="ml-image-id">
							<button id="update-image-details">Update</button>
							<div class="update-image-loading" style="display:none;">
								<img src="{{URL::asset('assets/images/loading-gray-light.gif')}}">
							</div>
						</p>
					</div>
				</div>
			</div>
			
			<div id="media-new" class="modal-body-upload modal-body-panel" style="display:none;">
				<form action="{{URL::route('media_library_upload')}}" class="dropzone dropzone-form-cont" id="dropzoneForm">
					<div class="modal-select dropzone-folder-select">
						<label for="dz-folder">Upload Directory</label>
						<select id="dz-folder" name="folder">
							<option value="page_images">page_images</option>
							<option value="product_images">product_images</option>
						</select>
						<p class="ml-chosen-image">Choose your image.</p>
					</div>
					<div class="ml-body">
						<input type="file" name="file" class="dropzone-file" />
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<input type="hidden" id="field-selected">
				<button type="button" class="btn btn-success choose-media" disabled>Set Image</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->