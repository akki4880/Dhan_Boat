<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Http;  
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Console\Command;
use App\Models\TradeDetail;


class StartBoat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-boat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the boat process.';


    /**
     * Execute the console command.
     */
    public function handle()
    {   
        $this->info("📈 Placing BUY order.");
    
        // $buy = $this->placeBuyOrder($symbol, $buyPrice);

        $buy['orderStatus'] = 'TRADED';
    
        if ($buy['orderStatus'] === 'TRADED') {
            $this->info("✅ Buy successful. Monitoring for target/stop-loss until 4:12 AM...");

            // $order_id = $buy['orderId'];
            // $stockDetails = $this->getOrderByid($order_id);

            // $targetPrice = $stockDetails['price'] + 50;
            // $stopLoss = $stockDetails['price'] - 50; // Stop loss at ₹1450
            // $deadline = now()->setTime(14, 45); // 2:45 PM
            $buyPrice = 1420;
            $targetPrice = $buyPrice + 50;
            $stopLoss =  $buyPrice - 50; // Stop loss at ₹1450
            $deadline = now()->setTime(4, 23); // 2:45 PM

            
            while (true) {
                $currentTime = now();
                $price = getLivePrice();
    
                $this->info("[$currentTime] Live Price: ₹$price");
    
                // 🎯 Target hit
                if ($price == $targetPrice) {
                    // $this->placeSellOrder($symbol);
                    $this->info("🎯 Target hit. Sold at ₹$price.");
                    TradeDetail::create([
                        'symbol' => 'RELIANCE', // Replace with actual symbol
                        'buy_price' => $buyPrice,
                        'target_price' => $targetPrice,
                        'stop_loss' => $stopLoss,
                        'deadline' => $deadline->format('H:i:s'),
                        'status' => 'TragetPrice',
                        'sell_price' => $price,
                    ]);
                    break;
                }
    
                // 🔻 Stop-loss hit
                if ($price == $stopLoss) {
                    // $this->placeSellOrder($symbol);
                    $this->warn("🛑 Stop-loss triggered. Sold at ₹$price.");
                    TradeDetail::create([
                        'symbol' => 'RELIANCE', // Replace with actual symbol
                        'buy_price' => $buyPrice,
                        'target_price' => $targetPrice,
                        'stop_loss' => $stopLoss,
                        'deadline' => $deadline->format('H:i:s'),
                        'status' => 'StopLoss',
                        'sell_price' => $price,
                    ]);
                    break;
                }
    
                // ⏰ Time-based exit
                if ($currentTime->gte($deadline)) {
                    // $this->placeSellOrder($symbol);
                    $this->info("⏰ Deadline 4:12 AM reached. Forced sell at ₹$price.");
                    TradeDetail::create([
                        'symbol' => 'RELIANCE', // Replace with actual symbol
                        'buy_price' => $buyPrice,
                        'target_price' => $targetPrice,
                        'stop_loss' => $stopLoss,
                        'deadline' => $deadline->format('H:i:s'),
                        'status' => 'DeadLine',
                        'sell_price' => $price,
                    ]);
                    break;
                }
    
                sleep(1); // Check every 5 seconds
            }
        } else {
            $this->error("❌ Buy order failed: " . json_encode($buy));
        }

    }
    
    
}
