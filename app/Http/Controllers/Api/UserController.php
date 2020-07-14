<?php

namespace App\Http\Controllers\Api;

use App\Facades\UserPermission;
use App\Http\Controllers\Controller;
use App\Libraries\User\UserLibrary;
use App\Models\Enum\PermissionsEnum;
use App\Models\File;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|string|min:6|regex:/^[a-zA-Z0-9_]{6,}$/|unique:App\Models\User,username',
                'email' => 'required|email|unique:App\Models\User,email',
                'password' => 'required|min:8',
            ]
        );

        if (!config('haakco.registration_enabled')) {
            abort(400, 'Registration is currently not open');
        }

        $user = User::create(
            [
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
            ]
        );
        $user->refresh();
        $success = [
//            'access_token' => $user->createToken(config('app.name'))->accessToken,
            'name' => $user->name,
            'uuid' => $user->uuid,
        ];

        return response()->json(['success' => $success]);
    }

    public function getMyUser(UserLibrary $userLibrary): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        return response()->json($userLibrary->getSimpleUserDetails($user));
    }

    /**
     * @param \App\Models\User $user
     * @param UserLibrary $userLibrary
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function getUser(UserLibrary $userLibrary, User $user): JsonResponse
    {
        UserPermission::testIfUserHasAnyPermission(
            [
                PermissionsEnum::SYSTEM_USERS_VIEW_NAME,
            ]
        );
        return response()->json($userLibrary->getSimpleUserDetails($user));
    }

    /**
     * @param Request $request
     * @param \App\Models\User $user
     * @param UserLibrary $userLibrary
     *
     * @return mixed
     * @throws Exception
     */
    public function addUserImage(Request $request, User $user, UserLibrary $userLibrary)
    {
        UserPermission::testIfUserHasAnyPermission(
            [
                PermissionsEnum::CLIENT_USERS_EDIT_NAME,
            ]
        );

        $imageFile = $request->file('file');

        $fileData = $userLibrary->addUserImage($user, $imageFile);

        if ($fileData instanceof File) {
            return [
                'url' => $fileData->url,
            ];
        }
        abort('Adding image failed');
    }

    /**
     * @param UserLibrary $userLibrary
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function users(UserLibrary $userLibrary): JsonResponse
    {
        UserPermission::testIfUserHasAnyPermission(
            [
                PermissionsEnum::SYSTEM_USERS_VIEW_NAME,
            ]
        );
        return response()->json($userLibrary->getAllSimpleUserDetails(User::all()));
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function getMyCompanies(): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        return response()->json($currentUser->companiesSimple());
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function getCompanies(User $user): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        UserPermission::testIfUserHasAnyPermission(
            [
                PermissionsEnum::SYSTEM_USERS_VIEW_NAME,
            ]
        );

        return response()->json($user->companiesSimple());
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function getMyPermissions(): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        return response()->json(
            $currentUser->permissionsSimple()
        );
    }

    /**
     * @param \App\Models\User $user
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function getPermissions(User $user): JsonResponse
    {
        UserPermission::testIfUserHasAnyPermission(
            [
                PermissionsEnum::SYSTEM_USERS_VIEW_NAME
            ]
        );
        return response()->json(
            $user->permissionsSimple()
        );
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function getMyRoles(): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        return response()->json(
            $currentUser->rolesSimple()
        );
    }

    /**
     * @param \App\Models\User $user
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function getRoles(User $user): JsonResponse
    {
        UserPermission::testIfUserHasAnyPermission(
            [
                PermissionsEnum::SYSTEM_USERS_VIEW_NAME,
            ]
        );
        return response()->json(
            $user->rolesSimple()
        );
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user instanceof User) {
            $token = $user->token();
            if ($token) {
                $token->revoke();
            }
        }

        $response = [
            'message' => 'You have been succesfully logged out!',
        ];
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @param \App\Models\User $user
     * @param \App\Libraries\User\UserLibrary $userLibrary
     *
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Exception
     */
    public function updateUser(Request $request, User $user, UserLibrary $userLibrary)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
            ]
        );

        UserPermission::allowIfIsUserOrUserHasAnyPermission(
            $user,
            [
                PermissionsEnum::SYSTEM_USERS_EDIT_NAME,
            ]
        );

        $email = $request->get('email');
        $name = $request->get('name');

        if ($user->email !== $email) {
            if (
                User::query()
                ->where('email', $email)
                ->exists()
            ) {
                return abort(400, 'Email already exists');
            }
        }

        $user->email = $email;
        $user->name = $name;
        $user->save();
        $user->refresh();

        return response()->json(
            $userLibrary->getSimpleUserDetails($user)
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Exception
     */
    public function updateUserPassword(Request $request, User $user)
    {
        $request->validate(
            [
                'oldPassword' => 'required',
                'newPassword' => 'required|min:8',
            ]
        );

        UserPermission::allowIfIsUserOrHasAnyPermission(
            $user,
            [
                PermissionsEnum::CLIENT_USERS_EDIT_NAME,
            ]
        );

        $oldPassword = $request->get('oldPassword');
        $newPassword = $request->get('newPassword');

//        dd([
//               $user,
//               $oldPassword,
//               $user->password,
//               Hash::check($oldPassword, $user->password)
//           ]);
        if (Hash::check($oldPassword, $user->password)) {
            $user->fill(
                [
                    'password' => Hash::make($newPassword),
                ]
            )
                ->save();
        } else {
            return abort(400, 'Invalid password');
        }


        return response()->json(
            [
                'msg' => 'Password Updated',
            ]
        );
    }
}
