#ifndef F_CPU 
#define F_CPU 8000000UL 
#endif

#include <AVR/IO.h>
#include <AVR/interrupt.h>
#include <math.h>
#include <util/delay.h>
#include <string.h>
#include <stdio.h> 
#include <stdlib.h>


#define BAUD 9600
#define ubrr 51
#define LIMITA 300

const double pi = 3.14159265358979323846;
int i=1,contor_led,u=0,cont_tmr1=0,cont_tmr0=0,t=0,t1=0;
volatile int j=1,k=0,ciclu=0,automatic=0,tel=0,cont_tel=0,aux,stare,timeout_dioda=0,intrerupt;
long suma=0;

//float y,z;
unsigned char r,c;
char buff[100];
int manual=1;



void initserial(void){
SREG=SREG&127;
UCSRB=(1<<RXEN)|(1<<TXEN);//enable transmiter and reciever
UBRRH=(unsigned char) (ubrr>>8);//set transfer rate
UBRRL=(unsigned char) ubrr ;
UCSRC=0x86;//8 data bit+1 stop data
UCSRB=UCSRB|192;//enable USART interupt TXCIE/RXCIE

//UCSRA=UCSRA|128;//activare recieve complete interupt
SREG=SREG|128;

}

void EEPROM_write(unsigned int uiAddress, unsigned char ucData)
{
/* Wait for completion of previous write */
while(EECR & (1<<EEWE))
;
/* Set up address and data registers */
EEAR = uiAddress;
EEDR = ucData;
/* Write logical one to EEMWE */
EECR |= (1<<EEMWE);
/* Start eeprom write by setting EEWE */
EECR |= (1<<EEWE);
}

unsigned char EEPROM_read(unsigned int uiAddress)
{
/* Wait for completion of previous write */
while(EECR & (1<<EEWE))
;
/* Set up address register */
EEAR = uiAddress;
/* Start eeprom read by writing EERE */
EECR |= (1<<EERE);
/* Return data from data register */
return EEDR;
}

int prints(char *string) 
{ 
    
   int count =0; 
   while ((string[count]) != '\0') 
   { 
      while ( !( UCSRA & (1<<UDRE)) );  // Wait for empty transmit buffer 
      UDR = (char)string[count++]; 
          
   }    
   //TxByte('_');
    UCSRA=UCSRA & 32;
   return 0; 

}


void inchis()
{
	stare=0;
	PORTD=PORTD|128;
	PORTD=PORTD&191;
	PORTB=PORTB&252;
	//_delay_ms(300);
	PORTB=PORTB|1;

}

void deschis()
{
	stare=1;
PORTB=PORTB&251; //laser
	
	PORTD=PORTD|64;
	PORTD=PORTD&127;
	PORTB=PORTB&252;
	//_delay_ms(300);
	PORTB=PORTB|2;
}

void pauza()
{
	stare=2;
	PORTB=PORTB&253;
	PORTB=PORTB&254;
	PORTD=PORTD&63;
}


ISR (USART_TXC_vect){

}


//****************** INTRERUPERE RECIEVE COMPLETE************
SIGNAL (SIG_UART_RECV){
//ISR(USART_RXC_vect ){

unsigned char r;

 r=UDR;
  
 //Aprinde led calculator
 // PD7=1;
 //PD7=0
 if(r==97)
   {k=2;	}
 if(r==98)
   k=0;
  if(r==99)
  k=2;
  if(r==100)
  k=3;
  if(r==32)
  k=4;
  if(r==49)
  {k=5;timeout_dioda=1000;}
  if(r==50)
  k=6;
}


//****************** INTRERUPERE TIMER0************
ISR(TIMER0_OVF_vect)
{int n,n1;
TCNT0=99;       //overflow 32,768ms
 
 n=50;
 n1=100;
 cont_tel++;
 
 if(timeout_dioda>1)
 	timeout_dioda--;


if(timeout_dioda==1)
	{k=6;timeout_dioda=0;}


 
 if(cont_tel>500)
 	{
		tel=0;
		cont_tel=0;
	}
 cont_tmr0++;
 if(automatic==0)
 {
 	if(cont_tmr0<=n)
 		PORTD=PORTD|32;  //palpaire led rosu
 	if(cont_tmr0>n)
 		PORTD=PORTD&223;
 }
 else
	PORTD=PORTD|32;
 if(cont_tmr0>n1)
 cont_tmr0=0;
//TIMSK=TIMSK&254;
}
//****************** INTRERUPERE TIMER1************
ISR(TIMER1_OVF_vect)
{int n,n1;
TCNT1=57722;          //overflow 8,191875 ms

 n=3;
 n1=6;
	if(cont_tmr1<n)
		PORTD=PORTD|32;
	
	if(cont_tmr1>=n)	PORTD=PORTD&223;
cont_tmr1++;	
	if(cont_tmr1>n1)
		cont_tmr1=0;



//TIMSK=TIMSK&251;
 }


int main(void)
{
 DDRD=DDRD|224; // iesire :pd5(alb),pd6(verde),pd7(albastru) leduri 
 DDRB=DDRB|7;	//iesire : pb0,pb1  releu pb2 dioda laser
 DDRB=DDRB&207;	//intrare pb4 telefon, pb5 releu reed
 DDRD=DDRD&227; 	//intrare intrerupatoare pd2(pauza),pd3,pd4
 DDRC=DDRC&227; 	//intrare intrerupatoare pc2(pauza),pc3,pc4
 PORTB=PORTB|48;  //activare pull-up pb 4,pb 5
 PORTD=PORTD|28;	//activare pull-up pd2,pd3,pd4
 PORTC=PORTC|28;	//activare pull-up pc2,pc3,pc4
 initserial();	
// PORTB=PORTB|4;  //setare dioda laser pornit

//timer0
TCCR0=5;	//ceas intern, prescaler 1024
TCNT0=99; // incarcare registru timer0 cu 0	
//TIMSK = TIMSK|1; //activare intrerupere tmr0

//timer1
TCCR1A=0;
TCCR1B=5;//tmr1 ceas intern, prescaler 64
TCNT1=0; //incarcare registru timer1 cu 0
//TIMSK = TIMSK|4;//intrerupere activa timer1

ADMUX=ADMUX |5;//adc0
ADCSRA= ADCSRA | 7; //adc prescaler 128
ADCSRA= ADCSRA | 128; //ADC enable	


SREG=SREG|128;

sprintf(buff," Bun venit!---Mcucsr=%u\n\r ",MCUCSR); 
//sprintf(buff,"  My project Silviu! \n\r "); 
				prints(buff);
	//EEPROM_write(1,automatic);
	k=EEPROM_read(1);


	MCUCSR=0;
	while(1)
	{
	aux=EEPROM_read(1);
		if(aux!=k)
	EEPROM_write(1,k);	

	if((PIND & (1<<PD3))==0)
			_delay_ms(80);
		if((PIND & (1<<PD3))==0)
		{k=2;}

	if((PIND & (1<<PD4))==0)
			_delay_ms(80);
		if((PIND & (1<<PD4))==0)
		{k=5;timeout_dioda=1000;}

	if((PIND & (1<<PD2))==0)
			_delay_ms(80);
		if((PIND & (1<<PD2))==0)
		{k=4;PORTB=PORTB&251;}//laser
		
		
		if((PINC & (1<<PC3))==0)
			_delay_ms(80);
		if((PINC & (1<<PC3))==0)
		{k=2;}

	if((PINC & (1<<PC4))==0)
			_delay_ms(80);
		if((PINC & (1<<PC4))==0)
		{k=5;timeout_dioda=1000;}

	if((PINC & (1<<PC2))==0)
			_delay_ms(80);
		if((PINC & (1<<PC2))==0)
		{k=4;PORTB=PORTB&251;}//laser


	switch(k)
	{
	case 2:
	deschis();
	break;
	
	case 3:
	inchis();
	break;
	
	case 4:
	pauza();
	break;

	case 5:
	

	PORTB=PORTB|4;
		suma=0;	
		for(i=0;i<10;i++)
			{
			ADCSRA = ADCSRA | 64; // ADC start conversie
			_delay_us(100);
			suma=suma+ADC;
			_delay_ms(1);
			}
	suma=suma/10.0;
	
//printf(buff," suma=%lu\n\r ",suma);
//				prints(buff);
//				_delay_ms(500);

	if(suma<400)	
		inchis();
		else
		pauza();

		break;
	case 6:	 
	
	PORTB=PORTB&251;
	break;
}
PORTD=PORTD|32;
//deschis();
//_delay_ms(10000);
//inchis();
//_delay_ms(10000);

	
	}


return 0;
}





