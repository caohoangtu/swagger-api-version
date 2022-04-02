<?php

namespace App\Http\Controllers\API\V2;

use App\Repositories\V2\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use function response;

class TodoController extends Controller
{
    protected $todo;

    /**
     * @OA\OpenApi(
     *     @OA\Info(
     *         version="2.0",
     *         title="Todo List Api Version 2",
     *         description="Demo Todo List Api Version 2",
     *     )
     * )
     */
    public function __construct(TodoRepositoryInterface $todo)
    {
        $this->todo = $todo;
    }

    /**
     * Create Todo
     * @OA\Post (
     *     path="/api/v2/todo/store",
     *     tags={"ToDo"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="content",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="priority",
     *                          type="number"
     *                      ),
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "content":"example content",
     *                     "priority":1
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="priority", type="number", example=1),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $todo = $this->todo->create($request->all());
        return response()->json($todo);
    }

    /**
     * Update Todo
     * @OA\Put (
     *     path="/api/v2/todo/update/{id}",
     *     tags={"ToDo"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="content",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="priority",
     *                          type="number"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "content":"example content",
     *                     "priority":1
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="priority", type="number", example=1),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      )
     * )
     */
    public function update($id, Request $request)
    {
        try {
            $todo = $this->todo->findById($id);
            $todo = $this->todo->update($todo, $request->all());
            return response()->json($todo);
        } catch (ModelNotFoundException $exception) {
            return response()->json(["msg" => $exception->getMessage()], 404);
        }
    }

    /**
     * Get Detail Todo
     * @OA\Get (
     *     path="/api/v2/todo/get/{id}",
     *     tags={"ToDo"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="priority", type="number", example=1),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *         )
     *     )
     * )
     */
    public function get($id)
    {
        $todo = $this->todo->findById($id);
        if ($todo) {
            return response()->json($todo);
        }
        return response()->json(["msg" => "Todo item not found"], 404);
    }

    /**
     * Get List Todo
     * @OA\Get (
     *     path="/api/v2/todo/gets",
     *     tags={"ToDo"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example="example title"
     *                     ),
     *                     @OA\Property(
     *                         property="content",
     *                         type="string",
     *                         example="example content"
     *                     ),
     *                     @OA\Property(
     *                         property="priority",
     *                         type="number",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function gets()
    {
        $todos = $this->todo->getAll();
        return response()->json(["rows" => $todos]);
    }

    /**
     * Delete Todo
     * @OA\Delete (
     *     path="/api/v2/todo/delete/{id}",
     *     tags={"ToDo"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="delete todo success")
     *         )
     *     )
     * )
     */
    public function delete($id)
    {
        try {
            $todo = $this->todo->findById($id);
            $this->todo->delete($todo);
            return response()->json(["msg" => "delete todo success"]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(["msg" => $exception->getMessage()], 404);
        }
    }
}
