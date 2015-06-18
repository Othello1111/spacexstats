<?php

class Object extends Eloquent {

	protected $table = 'objects';
	protected $primaryKey = 'object_id';
	public $timestamps = true;

	protected $hidden = [];
	protected $fillable = [];
	protected $guarded = [];

	protected $rules = array(
		'Image' => array(
			'title' => 'required|max:100',
		),
		'GIF' => array(
		),
		'Audio' => array(
		),
		'Video' => array(
		),
		'Document' => array(
		),
		'Tweet' => array(
		),
		'Article' => array(
		),
		'Comment' => array(
		),
		'Update' => array(
		)
	);

	// Relations
	public function mission() {
		return $this->belongsTo('mission');
	}

	public function user() {
		return $this->belongsTo('user');
	}

    // Validators
	public function isValidForUpload($input) {
		$validator = Validator::make($input, $rules);
	}

	public function isValidForSubmission($input, $missionControlType) {
		$type = MissionControlType::getType($missionControlType);

		$validator = Validator::make($input, $this->rules[$type]);
		return ($validator->passes() ? true : $validator->errors());
	}

    // Scoped Queries
    public function scopeQueued($query) {
        return $query->where('status','queued')->orderBy('created_at', 'DESC');
    }

    // Attribute accessors
    public function getAttributeThumbSmall() {
        // TODO: use if statements based on media type later
        return 'media/small/' . $this->filename;
    }

    public function getAttributeThumbLarge() {
        // TODO: use if statements based on media type later
        return 'media/large/' . $this->filename;
    }
}