<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Availability
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Availability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Availability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Availability query()
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperAvailability extends \Eloquent {}
}

namespace App{
/**
 * App\Booking
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperBooking extends \Eloquent {}
}

namespace App{
/**
 * App\Message
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperMessage extends \Eloquent {}
}

namespace App{
/**
 * App\Order
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperOrder extends \Eloquent {}
}

namespace App{
/**
 * App\Student
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperStudent extends \Eloquent {}
}

namespace App{
/**
 * App\Teacher
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $country
 * @property string $phone_number
 * @property string $video_url
 * @property string $hourly_price
 * @property string $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereHourlyPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereVideoUrl($value)
 * @mixin \Eloquent
 */
	class IdeHelperTeacher extends \Eloquent {}
}

namespace App{
/**
 * App\TeacherDescription
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDescription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperTeacherDescription extends \Eloquent {}
}

namespace App{
/**
 * App\TeacherDocument
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeacherDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperTeacherDocument extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $role
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser extends \Eloquent {}
}

