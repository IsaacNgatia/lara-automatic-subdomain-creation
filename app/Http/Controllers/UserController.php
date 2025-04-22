<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function destroy($id)
    {
        $admin = Admin::find($id);
       
   try {
            // Get the database name from the admin record
            $databaseName = 'ispkenya_' . $admin->database_name;

            // Delete the tenant database if it exists
            if ($databaseName) {
                DB::statement("DROP DATABASE IF EXISTS `$databaseName`");
            }

            // Delete the admin user
            $admin->delete();

            return redirect()->back()->with('success', 'User and associated database deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}