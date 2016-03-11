<?php

namespace Budget\Console\Commands;

use Goutte\Client;
use Illuminate\Console\Command;

class GetTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'budget:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads transactions from RBC';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        $crawler = $client->request('GET', 'http://www.rbcroyalbank.com/personal.html');
        $form = $crawler->selectButton('Sign In')->form();



        $crawler = $client->submit($form);
        $content = $crawler->filterXPath("//meta[@http-equiv='refresh']")->attr('content');
        $url = substr($content, strpos($content, "url=") + 4);

        $this->info("Getting login form from : ".$url);
        $crawler = $client->request('GET', $url);

        $form = $crawler->selectButton('Sign In')->form([
                'K1' => '4519019440597165', 
                'Q1' => env('RBC_PW','xxxxxx'),
            ]);

        $crawler = $client->submit($form);
        $this->info($crawler->html());

        return;

        $crawler->filter('.updatedBalance')->each(function ($node) {
            $this->info(var_export($node));
        });
    }
}
