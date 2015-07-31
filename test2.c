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
int i=1,contor_led,u=0,cont_tmr1=0,cont_tmr0=0,t=0,t1=0,s_servo=0;
volatile int j=1,k=0,ciclu=0,automatic=0,tel=0,cont_tel=0,aux,baux,stare,timeout_dioda=0,motor=0,timeout_motor=0,f_servo=0;
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
	//PORTB=PORTB&252;
	PORTC=PORTC&254;
	//_delay_ms(300);
	PORTB=PORTB|1;

}

void deschis()
{
	stare=1;
    PORTB=PORTB&251; //laser
	PORTD=PORTD|64;
	PORTD=PORTD&127;
	
	PORTB=PORTB&254;
	PORTC=PORTC|1;
	//_delay_ms(300);

}

void pauza()
{
	stare=2;
	PORTC=PORTC&254;
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
 if(r==52)
  {OCR1A=OCR1A+10;
  sprintf(buff," ocr1a=%u\n\r ",OCR1A); 
				prints(buff);}
	if(r==53)
  {OCR1A=OCR1A-10;
  sprintf(buff," ocr1a=%u\n\r ",OCR1A); 
				prints(buff);}

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
	{k=4;timeout_dioda=0;}

	if(timeout_motor>1)
 	timeout_motor--;


if(timeout_motor==1)
	{timeout_motor=0;}



 /*
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
 */
//TIMSK=TIMSK&254;

//actualizare servo
	if(f_servo==1)
	{
		if(OCR1A>1300 && s_servo)
		s_servo=0;
		if(OCR1A<350 && !s_servo)
		s_servo=1;

		if(s_servo)
		OCR1A=OCR1A+1;
		else
		OCR1A=OCR1A-1;
	}
	
	if(f_servo==2)
	{
		if(stare==0 && motor==1)
		OCR1A=OCR1A+1;
		if(stare==1 && motor==1)
		OCR1A=OCR1A-1;

		if(OCR1A>1300)
		OCR1A=1300;
		if(OCR1A<350)
		OCR1A=350;
	}
	  
			

}

//****************** INTRERUPERE TIMER1************
/*
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

*/
int main(void)
{
 DDRD=DDRD|224; // iesire :pd5(alb),pd6(verde),pd7(albastru) leduri 
 DDRB=DDRB|7;	//iesire : pb0 - releu; pb2 dioda laser; pb1 - servo;
 DDRC=DDRC|1; //iesire pc0 - releu;

 DDRC=DDRC&225; //PC4 - releu reed; pc3 - rpi deschide; pc2 - rpi inchide; pc1 - rpi pauza;
 DDRD=DDRD&227; 	//intrare intrerupatoare pd2(pauza),pd3,pd4

 PORTC=PORTC|30; //pull-up  PC4 - releu reed; pc3 - rpi deschide; pc2 - rpi inchide; pc1 - rpi pauza;
 PORTD=PORTD|28; //pull-up pd2 pd3 pd4 butoane;

 TCCR1A=TCCR1A|128; //OC1A ca pwm
 TCCR1B=18;//setare frecventa clock timer 64 prescaler
 
 ICR1=10440;//nr maxim la care OCR1A poate sa ajunga
 OCR1A=522;
	//OCR1A=1044;




//timer0
TCCR0=5;	//ceas intern, prescaler 1024
TCNT0=99; // incarcare registru timer0 cu 0	
TIMSK = TIMSK|1; //activare intrerupere tmr0


ADMUX=ADMUX |5;//adc0
ADCSRA= ADCSRA | 7; //adc prescaler 128
ADCSRA= ADCSRA | 128; //ADC enable	

initserial();

SREG=SREG|128;

sprintf(buff," Bun venit!---Mcucsr=%u\n\r ",MCUCSR); 
//sprintf(buff,"  My project Silviu! \n\r "); 
				prints(buff);
	//EEPROM_write(1,automatic);
	k=EEPROM_read(1);


	MCUCSR=0;

	f_servo=2;
	while(1)
	{
	aux=EEPROM_read(1);
		if(aux!=k)
	{baux=aux;
	EEPROM_write(1,k);}
	//PORTD=PORTD|32; // led verde pornit 
	
	//comenzi butoane PCB	

	if((PIND & (1<<PD3))==0)
			_delay_ms(80);
		if((PIND & (1<<PD3))==0)
		{timeout_motor=30;k=2;}

	if((PIND & (1<<PD4))==0)
			_delay_ms(80);
		if((PIND & (1<<PD4))==0)
			{timeout_motor=30; timeout_dioda=1000;
		 	k=5;
		 	}

	if((PIND & (1<<PD2))==0)
			_delay_ms(80);
		if((PIND & (1<<PD2))==0)
		{k=4;PORTB=PORTB&251;}//laser
		

		// comenzi de la RPI
		
		if((PINC & (1<<PC3))==0)
			_delay_ms(80);
		if((PINC & (1<<PC3))==0)
		{timeout_motor=30;k=2;}

	if((PINC & (1<<PC2))==0)
			_delay_ms(80);
		if((PINC & (1<<PC2))==0)
			{timeout_motor=30;timeout_dioda=1000;
			k=5;
			}

	if((PINC & (1<<PC1))==0)
			_delay_ms(80);
		if((PINC & (1<<PC1))==0)
		{k=4;PORTB=PORTB&251;}//laser

	//motor
	if((PINC & (1<<PC4))==0)
			_delay_ms(80);
		if((PINC & (1<<PC4))==0)
		{motor=1;}

	if((PINC & (1<<PC4)))
			_delay_ms(80);
		if((PINC & (1<<PC4)))
		{motor=0;}


if(motor==1)
PORTD=PORTD|32;
if(motor==0)
PORTD=PORTD&223;

	switch(k)
	{
	case 2:
	deschis();
	if(motor==0 && timeout_motor==0)
	k=4;
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
		{inchis();
		if(motor==0 && timeout_motor==0)
			k=4;
			
			timeout_dioda=1000;
		}
		else
		{pauza();timeout_motor=30;}

		break;

		default:
		k=baux;
		break;
}

//deschis();
//_delay_ms(10000);
//inchis();
//_delay_ms(10000);

	
	}


return 0;
}




