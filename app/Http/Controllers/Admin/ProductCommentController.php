<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\ProductComment\ProductCommentServiceInterface;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
    private $commentService;
    
    public function __construct(ProductCommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request)
    {
        $comments = $this->commentService->searchAndPaginate('id', $request->get('search'));
        return view('admin.comment.index', compact('comments'));
    }

    public function show($id)
    {
        $comment = $this->commentService->find($id);
        return view('admin.comment.show', compact('comment'));
    }

    public function destroy($id)
    {
        $this->commentService->delete($id);
        return redirect()->route('comment.index')->with('success', 'Xóa comment thành công!');
    }
}