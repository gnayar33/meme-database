A sends handshake
B returns handshake
A checks handshake
send bitfield between pair
if (other peer has pieces needed){
	send interested
}
else{
	send not interested
}

choose k peers to unchoke //HOW
	choke others
	while(! all peers have file) 
		if(recieve request){
			send piece containing requested piece
		}
		if(recieve bitfield or recieve have){
			send interested if it has pieces I need
		}
		if(time%p = 0){
			if(I dont have file){
				reevaluate subset of k interested peers based on rate transmitting to me
			}
			else{
				choose random subset of k interested peers 
			}
			unchoke new peers in subset, expect to recieve request from them
			choke all others to stop them from sending data
		}
		if(time%m = 0){
			choose random neighbor amongst choked yet interested peers
			send unchoke, expect to recieve request from them

		}
		update bitfield
		if(recieve unchoke from peer){
			send request for random piece I need and haven't requested before that peer has
			if(recieve piece){
				notify all peers of new piece with a have message
				request another
			}
			else{
				move on //HOW
			}
		}
