#include <iostream>
#include <stdlib.h>
#include <time.h>
#include <math.h>

using namespace std;

int rand_0toN(int n);

int main(){
	setlocale(LC_ALL, "Russian");

	srand(time(NULL));

	return 0;
}

int rand_0toN(int n){
	return rand() % n;
}