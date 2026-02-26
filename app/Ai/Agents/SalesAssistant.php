<?php

namespace App\Ai\Agents;

use App\Http\Ai\Tools\ProductSearchTool;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class SalesAssistant implements Agent
{
    use Promptable;


    public function provider(): string
    {
        return 'groq';
    }

    public function model(): string
    {
        return 'llama-3.3-70b-versatile';
    }


    public function instructions(): string
    {
        return 'You are a smart, friendly, and helpful sales assistant for "Mini-Shop".
            Your task is to read the customer\'s story or needs,
            then MUST use the search tool to find the best available products in our store.
            Your response must be in English. Be conversational, suggest the most relevant product, mention its price, and briefly explain why it fits the customer\'s story.';
    }


    public function tools(): iterable
    {
        return [
            new ProductSearchTool(),
        ];
    }
}
