use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\Department;

// Usuário autenticado
Route::get('/auth/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Funcionários
Route::get('/employees', function () {
    return response()->json(Employee::all());
});

Route::get('/employees/{id}', function ($id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['message' => 'Funcionário não encontrado'], 404);
    }
    return response()->json($employee);
});

Route::post('/employees', function (Request $request) {
    $employee = new Employee();
    $employee->name = $request->input('name');
    $employee->cpf = $request->input('cpf');
    $employee->email = $request->input('email');
    $employee->phone = $request->input('phone');
    $employee->basesalary = $request->input('basesalary');
    $employee->department_id = $request->input('department_id');
    $employee->save();
    return response()->json($employee);
});

Route::patch('/employees/{id}', function (Request $request, $id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['message' => 'Funcionário não encontrado'], 404);
    }

    if ($request->filled('name')) $employee->name = $request->input('name');
    if ($request->filled('cpf')) $employee->cpf = $request->input('cpf');
    if ($request->filled('email')) $employee->email = $request->input('email');
    if ($request->filled('phone')) $employee->phone = $request->input('phone');
    if ($request->filled('basesalary')) $employee->basesalary = $request->input('basesalary');

    $employee->save();
    return response()->json($employee);
});

Route::delete('/employees/{id}', function ($id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['message' => 'Funcionário não encontrado'], 404);
    }

    $employee->delete();
    return response()->json(['message' => 'Funcionário excluído com sucesso']);
});

// Funcionários com departamentos
Route::get('/employees-with-departments', function () {
    return response()->json(Employee::with('department')->get());
});

Route::get('/employees/{id}/department', function ($id) {
    $employee = Employee::with('department')->find($id);
    if (!$employee) {
        return response()->json(['message' => 'Funcionário não encontrado'], 404);
    }
    return response()->json($employee->department);
});

// Departamentos
Route::get('/departments', function () {
    return response()->json(Department::all());
});

Route::get('/departments/{id}', function ($id) {
    $department = Department::find($id);
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado'], 404);
    }
    return response()->json($department);
});

Route::post('/departments', function (Request $request) {
    $department = new Department();
    $department->name = $request->input('name');
    $department->description = $request->input('description');
    $department->save();
    return response()->json($department);
});

Route::patch('/departments/{id}', function (Request $request, $id) {
    $department = Department::find($id);
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado'], 404);
    }

    if ($request->filled('name')) $department->name = $request->input('name');
    if ($request->filled('description')) $department->description = $request->input('description');

    $department->save();
    return response()->json($department);
});

Route::delete('/departments/{id}', function ($id) {
    $department = Department::find($id);
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado'], 404);
    }

    $department->delete();
    return response()->json(['message' => 'Departamento excluído com sucesso']);
});

// Departamentos com funcionários
Route::get('/departments-with-employees', function () {
    return response()->json(Department::with('employees')->get());
});

Route::get('/departments/{id}/employees', function ($id) {
    $department = Department::with('employees')->find($id);
    if (!$department) {
        return response()->json(['message' => 'Departamento não encontrado'], 404);
    }
    return response()->json($department->employees);
});
