<?php

namespace Bundle\LichessBundle\Chess\Generator;

use Bundle\LichessBundle\Document\Game;

class StandardPositionGenerator extends PositionGenerator
{
    public function createPieces(Game $game)
    {
        $pieces = array();
        $player = $game->getPlayer('white');

        foreach(explode(' ', 'Rook Knight Bishop Queen King Bishop Knight Rook') as $x => $class)
        {
            $pieces[] = $this->createPiece('Pawn', $x+1, 2);
            $pieces[] = $this->createPiece($class, $x+1, 1);
        }

        $player->setPieces($pieces);
        $player->getOpponent()->setPieces($this->mirrorPieces($pieces));

        $game->setInitialFen(null);
    }

    public function createPiecesMinimal(Game $game)
    {
        $pieces = array();
        $player = $game->getPlayer('white');
        $pieces[] = $this->createPiece('Pawn', 1, 2);
        $player->setPieces($pieces);
        $player->getOpponent()->setPieces($this->mirrorPieces($pieces));

        $game->setInitialFen(null);
    }
}
