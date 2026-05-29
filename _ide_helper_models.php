<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $tutor_id
 * @property int $subject_id
 * @property string $session_date
 * @property int $hours
 * @property numeric $total_price
 * @property string $status
 * @property string $session_mode
 * @property string|null $meeting_link
 * @property string $payment_status
 * @property string|null $razorpay_payment_id
 * @property string|null $razorpay_order_id
 * @property string|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $student
 * @property-read \App\Models\Subject $subject
 * @property-read \App\Models\Tutor $tutor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereMeetingLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereRazorpayOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereRazorpayPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereSessionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereSessionMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereTutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $tutors
 * @property-read int|null $tutors_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subject whereUpdatedAt($value)
 */
	class Subject extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $address
 * @property numeric $price_per_hour
 * @property string $bio
 * @property int $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subject|null $subject
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor wherePricePerHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutor whereUserId($value)
 */
	class Tutor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

