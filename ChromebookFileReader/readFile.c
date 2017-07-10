#include <stdio.h>
#include<stdlib.h>
#include<string.h>

void compareData(char *room, char *asset) {
  char searchString[BUFSIZ] = {0};
  FILE *fp = fopen("Chromebook Mass Export.txt", "r");
  if(fp == NULL) {
    printf("COULD NOT OPEN OTHER FILE\n");
    return;
  }
  while(fgets(searchString, BUFSIZ, fp)) {
    char *orgUnit = strtok(searchString, ",");
    char *roomNote = strtok(NULL, ",");
    char *assetNote = strtok(NULL, ",");
    char *serialNumber = strtok(NULL, ",");
    char *model = strtok(NULL, ",");

    if(strncmp(asset, assetNote, 4) == 0) {
      printf("%s | %s | %s", assetNote, serialNumber, model);
      fclose(fp);
      return;
    }
  }
  printf("COULD NOT FIND %s", asset);
  fclose(fp);
}

int main() {
  char string[BUFSIZ] = {0};

  FILE *fp = fopen("data.txt", "r");
  if(fp == NULL) {
    printf("COULD NOT OPEN FILE\n");
  }
  else {
    printf("SUCCESSFULLY OPENED FILE\n");
  }

  while(fgets(string, BUFSIZ, fp)) {
    char *room = strtok(string, ",");
    char *asset = strtok(NULL, ",");
    compareData(room, asset); 
  }
  return 0;

}
